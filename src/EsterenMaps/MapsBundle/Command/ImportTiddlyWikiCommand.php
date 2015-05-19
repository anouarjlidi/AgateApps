<?php
namespace EsterenMaps\MapsBundle\Command;

use DateTime;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Factions;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\MarkersTypes;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use EsterenMaps\MapsBundle\Entity\Zones;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\ZonesTypes;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use Orbitale\Component\EntityMerger\EntityMerger;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportTiddlyWikiCommand extends ContainerAwareCommand
{

    /**
     * @var array
     */
    protected $datas = array();

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var boolean
     */
    protected $dryRun = true;

    /**
     * @var Maps[]
     */
    protected $maps = array();

    /**
     * @var Factions[]
     */
    protected $factions = array();

    /**
     * @var MarkersTypes[]
     */
    protected $markersTypes = array();

    /**
     * @var ZonesTypes[]
     */
    protected $zonesTypes = array();

    /**
     * @var RoutesTypes[]
     */
    protected $routesTypes = array();

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('esterenmaps:import:tiddly-wiki')
            ->setDescription('Generate all tiles for a specific map.')
            ->setHelp('This command imports datas from a tiddly wiki file or url into the database.')
            ->addArgument('file', InputArgument::REQUIRED, 'The file or the url to check.')
            ->addOption('force', 'f', InputOption::VALUE_OPTIONAL, 'Executes the command instead of just showing modified elements.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $this->dryRun = !$input->getOption('force');

        $file = $input->getArgument('file');

        $datas = file_get_contents($file);

        if (!$datas) {
            throw new \Exception('Tiddly wiki content could not be retrieved.');
        }

        $datas = json_decode($datas, true);

        if (!$datas) {
            throw new \Exception('Json error while decoding: <error>'.json_last_error_msg().'</error>.');
        }

        $this->em = $this->getContainer()->get('doctrine')->getManager();

        // Setting all datas in the class for we can use it in the other methods
        $this->datas = $datas;
        $total = count($datas);

        $output->writeln('Found <info>'.$total.'</info> items to check for import.');

        $output->writeln('Processing...');

        $this->maps         = $this->em->getRepository('EsterenMapsBundle:Maps')->findAllRoot('id');
        $this->factions     = $this->getReferenceObjects('factions', 'EsterenMapsBundle:Factions', 'id_faction');
        $this->markersTypes = $this->getReferenceObjects('markertype', 'EsterenMapsBundle:MarkersTypes', 'id_marker');
        $this->zonesTypes   = $this->getReferenceObjects('zonetype', 'EsterenMapsBundle:ZonesTypes', 'id_zonetype');
        $this->routesTypes  = $this->getReferenceObjects('routetype', 'EsterenMapsBundle:RoutesTypes', 'id_route');

        $this->processObjects('routes', 'EsterenMapsBundle:Routes', 'id_');
        $this->processObjects('zones', 'EsterenMapsBundle:Zones', 'id_');
        $this->processObjects('marqueurs', 'EsterenMapsBundle:Markers', 'id_');

        $this->em->getUnitOfWork()->computeChangeSets();

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $updates = $this->em->getUnitOfWork()->getScheduledEntityUpdates();
            $updatesCollec = $this->em->getUnitOfWork()->getScheduledCollectionUpdates();
            $this->showProcessed('Update', array_merge($updates, $updatesCollec));
            $inserts = $this->em->getUnitOfWork()->getScheduledEntityInsertions();
            $this->showProcessed('Add', $inserts);
        }

        if ($this->dryRun) {
            $output->writeln('Finished processing dry run.');
        } else {
            try {
                $this->em->flush();
            } catch (\Exception $e) {
                throw new \RuntimeException('An error occured when trying to update the database.', null, $e);
            }
        }

        //TODO: Update the whole TiddlyWiki file to manage updates

    }

    /**
     * @param string $tag
     * @param string $entity
     * @param string $idToReplace
     * @param string $nameProperty
     *
     * @return object[]
     */
    protected function getReferenceObjects($tag, $entity, $idToReplace, $nameProperty = 'name')
    {
        $datas = array_filter($this->datas, function ($element) use ($tag) {
            return isset($element['tags']) && $element['tags'] === $tag;
        });

        /** @var BaseEntityRepository $repo */
        $repo = $this->em->getRepository($entity);

        $objects = $repo->findAllRoot('id');

        foreach ($datas as $data) {

            if (strpos($data['id'], $idToReplace) === 0) {
                $exists = $repo->findOneBy(array($nameProperty => $data['title']));
                if (!$exists) {
                    $object = new MarkersTypes();
                    $object->{'set'.ucfirst($nameProperty)}($data['title']);
                    $this->em->persist($object);

                    if ($this->dryRun) {
                        $object->setId($data['id']);
                    } else {
                        $this->em->flush($object);
                    }
                    $objects[$object->getId()] = $object;
                }
            }
        }

        return $objects;
    }

    /**
     * @param string $tag
     * @param string $entity
     * @param string $idToReplace
     *
     * @return object[]
     */
    protected function processObjects($tag, $entity, $idToReplace)
    {
        $datas = array_filter($this->datas, function ($element) use ($tag) {
            return isset($element['tags']) && $element['tags'] === $tag;
        });

        /** @var BaseEntityRepository $repo */
        $repo = $this->em->getRepository($entity);

        $objects = $repo->findAllRoot('id');

        $merger = new EntityMerger($this->em, $this->getContainer()->get('jms_serializer'));

        foreach ($datas as $data) {

            $type             = $data['tags'];
            $id               = isset($data['id']) ? $data['id'] : null;
            $data['created']  = DateTime::createFromFormat('YmdHisu', isset($data['created']) ? $data['created'] : date('YmdHisu'));
            $data['modified'] = DateTime::createFromFormat('YmdHisu', isset($data['modified']) ? $data['modified'] : date('YmdHisu'));

            if (strpos($data['id'], $idToReplace) === 0) {
                $object = $repo->findOneBy(array('name' => $data['title']));
                if (!$object) {
                    $object = new Routes();

                    if ($this->dryRun) {
                        $object->setId($data['id']);
                    }
                }
            } else {
                $object = $repo->find($id);
                if (!$object) {
                    $this->output->writeln('<error>Did not find "'.$tag.'" object with id "'.$id.'".</error>');
                    continue;
                }
            }

            switch ($type) {
                case 'marqueurs':
                    $object = $merger->merge($object, $data, array(
                        'id' => true,
                        'title' => array('objectField' => 'description'),
                        'created' => array('objectField' => 'createdAt'),
                        'modified' => array('objectField' => 'updatedAt'),
                    ));
                    if (!$object->isLocalized()) {
                        $object->setLatitude(0)->setLongitude(0);
                    }
                    break;
                case 'routes':
                    $object = $merger->merge($object, $data, array(
                        'id' => true,
                        'title' => array('objectField' => 'description'),
                        'created' => array('objectField' => 'createdAt'),
                        'modified' => array('objectField' => 'updatedAt'),
                    ));
                    if (!$object->isLocalized()) {
                        $object->setCoordinates(array(
                            array('lat' => 0, 'lng' => 0),
                            array('lat' => 1, 'lng' => 1),
                        ));
                    }
                    break;
                case 'zones':
                    $object = $merger->merge($object, $data, array(
                        'id' => true,
                        'title' => array('objectField' => 'description'),
                        'created' => array('objectField' => 'createdAt'),
                        'modified' => array('objectField' => 'updatedAt'),
                    ));
                    if (!$object->isLocalized()) {
                        $object->setCoordinates(array(
                            array('lat' => 0, 'lng' => 0),
                            array('lat' => 0, 'lng' => 1),
                            array('lat' => 1, 'lng' => 0),
                        ));
                    }
                    break;
                default:
                    throw new \RuntimeException('Unknown type "'.$type.'".');
            }

            $metadata = $this->em->getClassMetaData(get_class($object));
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

            if (method_exists($object, 'setUpdatedAt')) {
                $object->setUpdatedAt(new DateTime());
            }
            $this->em->persist($object);
        }

        return $objects;
    }

    /**
     * @param string   $processType
     * @param object[] $objects
     */
    private function showProcessed($processType, $objects)
    {
        foreach ($objects as $object) {
            $class = explode('\\', get_class($object));
            $class = array_pop($class);
            if (in_array($class, array('Markers', 'Zones', 'Routes'))) {
                $type = 'object';
                $refType = 'id';
                if ($processType === 'Update') {
                    $ref = (string) $object;
                } else {
                    $ref = $object->getId();
                }
            } else {
                $type = 'reference';
                $refType = 'name';
                $ref = $object->getName();
            }
            $this->output->writeln(' > <comment>'.$processType.'</comment> '.$type.' of type <comment>'.$class.'</comment> with '.$refType.' <info>'.$ref.'</info>');
        }
    }

}
