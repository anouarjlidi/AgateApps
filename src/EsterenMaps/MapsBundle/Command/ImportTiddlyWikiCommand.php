<?php
namespace EsterenMaps\MapsBundle\Command;

use DateTime;
use Doctrine\ORM\EntityRepository;
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
use Symfony\Component\Console\Helper\Table;
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
        $code = 100;

        $time = microtime(true);

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

        $tags = array_reduce($datas, function($carry, $object) {
            $carry[$object['tags']] = array(
                'tag' => $object['tags'],
                'nb_occurrences' => isset($carry[$object['tags']]['nb_occurrences']) ? $carry[$object['tags']]['nb_occurrences']+1 : 1,
            );
            return $carry;
        });
        $table = new Table($output);
        $table->setHeaders(array('Tag found', 'Count'));
        $table->setRows($tags);
        $table->render();

        $this->maps         = $this->getRepository('EsterenMapsBundle:Maps')->findAllRoot('id');
        $this->factions     = $this->getReferenceObjects('factions', Factions::class, 'id_');
        $this->markersTypes = $this->getReferenceObjects('markertype', MarkersTypes::class, 'id_marker');
        $this->zonesTypes   = $this->getReferenceObjects('zonetype', ZonesTypes::class, 'id_zone');
        $this->routesTypes  = $this->getReferenceObjects('routetype', RoutesTypes::class, 'id_route');

        $this->markers = $this->processObjects('marqueurs', Markers::class, 'id_');
        $this->zones   = $this->processObjects('zones', Zones::class, 'id_');
        $this->routes  = $this->processObjects('routes', Routes::class, 'id_');

        if ($this->dryRun) {
            $output->writeln('Finished processing dry run.');
            $code = 1;
        } else {
            try {
                $output->write('Attempting to flush all datas...');
                $this->em->flush();
                $output->writeln(' <info>Ok!</info>');
                $code = 0;
            } catch (\Exception $e) {
                throw new \RuntimeException('An error occured when trying to update the database.', null, $e);
            }
        }

        $idsUpdated = 0;

        foreach ($this->datas as $k => $data) {
            $id = $data['id'];

            if (is_numeric($id)) {
                continue;
            }

            $newId = null;

            switch ($data['tags']) {
                case 'marqueurs':
                    $newId = $this->markers['new'][$id]->getId();
                    break;
                case 'zones':
                    $newId = $this->zones['new'][$id]->getId();
                    break;
                case 'routes':
                    $newId = $this->routes['new'][$id]->getId();
                    break;
                case 'factions':
                    $newId = $this->factions['new'][$id]->getId();
                    break;
            }

            if ($newId) {
                $this->datas[$k]['id'] = $newId;
                $idsUpdated++;
            }
        }

        $json = json_encode($this->datas, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_BIGINT_AS_STRING);
        file_put_contents($file, $json);
        $output->writeln('Updated <info>'.$idsUpdated.'</info> identifiers in the JSON file.');

        $output->writeln('Executed in '.number_format(microtime(true) - $time, 4).' seconds');
        return $code;
    }

    /**
     * @param string $tag
     * @param string $entity
     * @param string $idToReplace
     * @param string $nameProperty
     *
     * @return array
     */
    private function getReferenceObjects($tag, $entity, $idToReplace, $nameProperty = 'name')
    {
        $datas = array_filter($this->datas, function ($element) use ($tag) {
            return isset($element['tags']) && $element['tags'] === $tag;
        });

        $repo = $this->getRepository($entity);

        $new = array();
        $existing = array();

        $objects = $repo->findAllRoot('id');

        foreach ($datas as $data) {

            $object = null;

            $id = $data['id'];

            // Checks automatically if the objects exists from its ID.
            // If not, we get the object by title
            if (isset($objects[$id])) {
                $object = $objects[$id];
            } elseif ($object = $repo->findOneBy(array($nameProperty => $data['title']))) {}

            if ($object) {
                $existing[$object->getId()] = $object;
                $type = '~ Update ';
            } else {
                $object = new $entity();
                $type = '+ Add    ';
                $new[$id] = $object;
            }

            $object->{'set'.ucfirst($nameProperty)}($data['title']);

            $this->showOneProcessed('reference', $type, $object);

            $this->em->persist($object);
        }

        foreach ($objects as $object) {
            if (!isset($existing[$object->getId()])) {
                $existing[$object->getId()] = $object;
                $this->showOneProcessed('reference', 'Don\'t touch', $object);
            }
        }

        return array(
            'new' => $new,
            'existing' => $existing,
        );
    }

    /**
     * @param string $tag
     * @param string $entity
     *
     * @return array
     */
    private function processObjects($tag, $entity)
    {
        $datas = array_filter($this->datas, function ($element) use ($tag) {
            return isset($element['tags']) && $element['tags'] === $tag;
        });

        $repo = $this->getRepository($entity);

        $new = array();
        $existing = array();

        $objects = $repo->findAllRoot('id');

        foreach ($datas as $data) {

            $object = null;

            $id = $data['id'];

            // Checks automatically if the objects exists from its ID.
            // If not, we get the object by title
            if (isset($objects[$id])) {
                $object = $objects[$id];
            } elseif ($object = $repo->findOneBy(array('name' => $data['title']))) {}

            if ($object) {
                $existing[$object->getId()] = $object;
                $type = '~ Update ';
            } else {
                $object = new $entity();
                $type = '+ Add    ';
                $new[$id] = $object;
            }

            $object->{'set'.ucfirst('name')}($data['title']);

            $this->showOneProcessed('object', $type, $object);

            $this->updateOneObject($object, $data);

            $this->em->persist($object);
        }

        foreach ($objects as $object) {
            if (!isset($existing[$object->getId()])) {
                $existing[$object->getId()] = $object;
                $this->showOneProcessed('object', '= Nothing', $object);
            }
        }

        return array(
            'new' => $new,
            'existing' => $existing,
        );
    }

    /**
     * @param string $objectType
     * @param string $processType
     * @param object $object
     */
    private function showOneProcessed($objectType, $processType, $object)
    {
        $class = explode('\\', get_class($object));
        $class = array_pop($class);
        $ref = (string) $object;
        $processType = $processType ? '<comment>'.$processType.'</comment>' : '';
        $this->output->writeln(' '.$processType.'</comment> '.$objectType.' of type <comment>'.$class.'</comment>: <info>'.$ref.'</info>');
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

    private function updateOneObject($object, $data)
    {
        $data['created']  = DateTime::createFromFormat('YmdHisu', isset($data['created']) ? $data['created'] : date('YmdHisu'));

        $object
            ->setId(is_numeric($data['id']) ? $data['id'] : null)
            ->setName($data['title'])
            ->setDescription($data['text'])
            ->setMap($this->maps[$data['map_id']])
            ->setFaction($this->getOneReferencedObject('factions', $data['faction_id']))
            ->setCreatedAt($data['created'])
        ;

        if (method_exists($object, 'setUpdatedAt')) {
            $object->setUpdatedAt(new DateTime());
        }

        if ($object instanceof Markers) {
            $object
                ->setMarkerType($this->getOneReferencedObject('markersTypes', $data['markertype_id']))
            ;
            if (!$object->isLocalized()) {
                $object->setLatitude(0)->setLongitude(0);
            }
        } elseif ($object instanceof Routes) {
            $object
                ->setRouteType($this->getOneReferencedObject('routesTypes', $data['routetype_id']))
                ->setMarkerStart($this->getOneReferencedObject('markers', $data['markerstart_id']))
                ->setMarkerEnd($this->getOneReferencedObject('markers', $data['markerend_id']))
            ;
            if (!$object->isLocalized()) {
                $object->setCoordinates(array(
                    array('lat' => 0, 'lng' => 0),
                    array('lat' => 1, 'lng' => 1),
                ));
            }
        } elseif ($object instanceof Zones) {
            $object
                ->setZoneType($this->getOneReferencedObject('zonesTypes', $data['zonetype_id']))
            ;
            if (!$object->isLocalized()) {
                $object->setCoordinates(array(
                    array('lat' => 0, 'lng' => 0),
                    array('lat' => 0, 'lng' => 1),
                    array('lat' => 1, 'lng' => 0),
                ));
            }
        } else {
            throw new \RuntimeException('Unknown type "'.$data['tags'].'".');
        }
    }

    private function getOneReferencedObject($type, $id)
    {
        $object = null;
        if ($id) {
            $datas = $this->$type;
            if (isset($datas['new'][$id])) {
                $object = $datas['new'][$id];
            } elseif (isset($datas['existing'][$id])) {
                $object = $datas['existing'][$id];
            }
        }
        return $object;
    }

}
