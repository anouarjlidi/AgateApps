<?php
namespace EsterenMaps\MapsBundle\Command;

use DateTime;
use Doctrine\ORM\EntityRepository;
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
    private $datas = array();

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var boolean
     */
    private $dryRun = true;

    /**
     * @var Maps[]
     */
    private $maps = array();

    /**
     * @var Factions[]
     */
    private $factions = array();

    /**
     * @var MarkersTypes[]
     */
    private $markersTypes = array();

    /**
     * @var ZonesTypes[]
     */
    private $zonesTypes = array();

    /**
     * @var RoutesTypes[]
     */
    private $routesTypes = array();

    /**
     * @var Routes[]
     */
    private $routes = array();

    /**
     * @var Zones[]
     */
    private $zones = array();

    /**
     * @var Markers[]
     */
    private $markers = array();

    /**
     * @var array
     */
    private $repos = array();

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
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Executes the command instead of just showing modified elements.')
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

        $this->maps         = $this->getRepository('EsterenMapsBundle:Maps')->findAllRoot('id');
        $this->factions     = $this->getReferenceObjects('factions', Factions::class, 'id_');
        $this->markersTypes = $this->getReferenceObjects('markertype', MarkersTypes::class, 'id_marker');
        $this->zonesTypes   = $this->getReferenceObjects('zonetype', ZonesTypes::class, 'id_zone');
        $this->routesTypes  = $this->getReferenceObjects('routetype', RoutesTypes::class, 'id_route');

        $this->processObjects('marqueurs', Markers::class, 'id_');
        $this->processObjects('zones', Zones::class, 'id_');
        $this->processObjects('routes', Routes::class, 'id_');

        // Edit ALL entities before processing flush
        $this->em->getUnitOfWork()->computeChangeSets();

        $updates = $this->em->getUnitOfWork()->getScheduledEntityUpdates();
        $updatesCollec = $this->em->getUnitOfWork()->getScheduledCollectionUpdates();
        $this->showProcessed('Update', array_merge($updates, $updatesCollec));
        $inserts = $this->em->getUnitOfWork()->getScheduledEntityInsertions();
        $this->showProcessed('Add', $inserts);

        if ($this->dryRun) {
            $output->writeln('Finished processing dry run.');
            return 1;
        }

        try {
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \RuntimeException('An error occured when trying to update the database.', null, $e);
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
    private function getReferenceObjects($tag, $entity, $idToReplace, $nameProperty = 'name')
    {
        $datas = array_filter($this->datas, function ($element) use ($tag) {
            return isset($element['tags']) && $element['tags'] === $tag;
        });

        $repo = $this->getRepository($entity);

        $objects = $repo->findAllRoot('id');

        foreach ($datas as $data) {

            $id = $data['id'];

            if (strpos($id, $idToReplace) === 0) {
                $exists = $repo->findOneBy(array($nameProperty => $data['title']));
                if (!$exists) {
                    $object = new $entity();
                } else {
                    $object = $exists;
                }
            } elseif (isset($objects[$id])) {
                $object = $objects[$id];
            } else {
                throw new \RuntimeException('Could not retrieve reference of type "'.$tag.'" with id "'.$id.'".');
            }

            $object->{'set'.ucfirst($nameProperty)}($data['title']);
            $object->setId($id);

            $this->em->persist($object);

            $objects[$object->getId()] = $object;
        }

        return $objects;
    }

    /**
     * @param string $tag
     * @param string $entity
     * @param string $idToReplace
     */
    private function processObjects($tag, $entity, $idToReplace)
    {
        $datas = array_filter($this->datas, function ($element) use ($tag) {
            return isset($element['tags']) && $element['tags'] === $tag;
        });

        $repo = $this->getRepository($entity);

        // Fetch base objects
        $objects = $repo->findAllRoot('id');
        $finalObjects = array();

        foreach ($datas as $data) {

            /** @var Routes|Markers|Zones $object */
            $object = null;

            $type = $data['tags'];
            $id   = isset($data['id']) ? $data['id'] : null;

            if (strpos($data['id'], $idToReplace) === 0) {
                $object = $repo->findOneBy(array('name' => $data['title']));
                if (!$object) {
                    $object = new $entity();
                }
            } else {
                if (isset($objects[$id])) {
                    $object = $objects[$id];
                } else {
                    $this->output->writeln('<error>Did not find "'.$tag.'" object with id "'.$id.'".</error>');
                    continue;
                }
            }

            if ($this->dryRun && !$object->getId()) {
                $object->setId($id);
            }

            $data = $this->normalizeData($data);

            switch ($type) {
                case 'marqueurs':
                    $object
                        ->setId($data['id'])
                        ->setName($data['title'])
                        ->setDescription($data['text'])
                        ->setMap($data['map_id'])
                        ->setFaction($data['faction_id'] ?: null)
                        ->setMarkerType($data['markertype_id'])
                    ;
                    $object->setCreatedAt($data['created']);
                    $object->setUpdatedAt($data['modified']);
                    if (!$object->isLocalized()) {
                        $object->setLatitude(0)->setLongitude(0);
                    }
                    break;
                case 'routes':
                    dump($data);
                    $object
                        ->setId($data['id'])
                        ->setName($data['title'])
                        ->setDescription($data['text'])
                        ->setMap($data['map_id'])
                        ->setFaction($data['faction_id'] ?: null)
                        ->setRouteType($data['routetype_id'])
                        ->setMarkerStart($data['markerstart_id'] ?: null)
                        ->setMarkerEnd($data['markerend_id'] ?: null)
                    ;
                    $object->setCreatedAt($data['created']);
                    $object->setUpdatedAt($data['modified']);
                    if (!$object->isLocalized()) {
                        $object->setCoordinates(array(
                            array('lat' => 0, 'lng' => 0),
                            array('lat' => 1, 'lng' => 1),
                        ));
                    }
                    break;
                case 'zones':
                    $object
                        ->setId($data['id'])
                        ->setName($data['title'])
                        ->setDescription($data['text'])
                        ->setMap($data['map_id'])
                        ->setFaction($data['faction_id'] ?: null)
                        ->setZoneType($data['zonetype_id'])
                    ;
                    $object->setCreatedAt($data['created']);
                    $object->setUpdatedAt($data['modified']);
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

            if (method_exists($object, 'setUpdatedAt')) {
                $object->setUpdatedAt(new DateTime());
            }

            $finalObjects[$object->getId()] = $object;

            switch ($tag) {
                case 'zones':
                    $this->zones = $finalObjects;
                    break;
                case 'marqueurs':
                    $this->markers = $finalObjects;
                    break;
                case 'routes':
                    $this->routes = $finalObjects;
                    break;
            }

            $this->em->persist($object);
            usleep(31250*3);
        }

        switch ($tag) {
            case 'zones':
                $this->zones = $finalObjects;
                break;
            case 'marqueurs':
                $this->markers = $finalObjects;
                break;
            case 'routes':
                $this->routes = $finalObjects;
                break;
        }
    }

    /**
     * @param string   $processType
     * @param object[] $objects
     */
    private function showProcessed($processType, array $objects = array())
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
            usleep(31250);
        }
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function normalizeData(array $data)
    {
        $data['created']  = DateTime::createFromFormat('YmdHisu', isset($data['created']) ? $data['created'] : date('YmdHisu'));
        $data['modified'] = DateTime::createFromFormat('YmdHisu', isset($data['modified']) ? $data['modified'] : date('YmdHisu'));

        $fieldsToNormalize = array(
            'map_id'         => array('property' => 'maps'),
            'markertype_id'  => array('property' => 'markersTypes'),
            'routetype_id'   => array('property' => 'routesTypes'),
            'zonetype_id'    => array('property' => 'zonesTypes'),
            'markerend_id'   => array('property' => 'markers'),
            'markerstart_id' => array('property' => 'markers'),
            'faction_id'     => array('property' => 'factions'),
        );

        foreach ($fieldsToNormalize as $field => $attr) {
            $property = $attr['property'];
            if (!isset($this->$property)) {
                throw new \InvalidArgumentException('Property '.$property.' does not exist as reference.');
            }
            $list = $this->$property;
            if (isset($data[$field]) && isset($list[$data[$field]])) {
                $data[$field] = $list[$data[$field]];
            } elseif (
                isset($data[$field])
                && !in_array($field, array('faction_id', 'markerend_id', 'markerstart_id')) // Some nullable fields
            ) {
                if (in_array($field, array('faction_id', 'markerend_id', 'markerstart_id'))) {
                    dump($data[$field]);exit;
                    //TODO
                }
                throw new \RuntimeException('<error>Could not find "'.$property.'" reference object with id "'.$data[$field].'".</error>');
            }
        }

        return $data;
    }

    /**
     * @param string $entityName
     *
     * @return EntityRepository|BaseEntityRepository
     */
    private function getRepository($entityName)
    {
        if (!isset($this->repos[$entityName])) {
            $this->repos[$entityName] = $this->em->getRepository($entityName);
        }
        return $this->repos[$entityName];
    }

}
