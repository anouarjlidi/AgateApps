<?php
namespace EsterenMaps\MapsBundle\Command;

use DateTime;
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
    protected $datas = array();

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var OutputInterface
     */
    protected $output;

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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $file = $input->getArgument('file');

        $datas = file_get_contents($file);

        if (!$datas) {
            throw new \Exception('Tiddly wiki content could not be retrieved.');
        }

        $datas = json_decode($datas, true);

        if (!$datas) {
            throw new \Exception('Json error while decoding: <error>'.json_last_error_msg().'</error>.');
        }

        /**
         * @var EntityManager $this->em
         */
        $this->em = $this->getContainer()->get('doctrine')->getManager();

        // Setting all datas in the class for we can use it in the other methods
        $this->datas = $datas;

        $output->writeln('Processing reference datas');
        /** @var Markers[] $markers */
        /** @var Zones[] $zones */
        /** @var Routes[] $routes */
        /** @var Maps[] $maps */
        /** @var Factions[] $factions */
        /** @var MarkersTypes[] $markersTypes */
        /** @var ZonesTypes[] $zonesTypes */
        /** @var RoutesTypes[] $routesTypes */
        $markers = $this->em->getRepository('EsterenMapsBundle:Markers')->findAllRoot('id');
        $zones = $this->em->getRepository('EsterenMapsBundle:Zones')->findAllRoot('id');
        $routes = $this->em->getRepository('EsterenMapsBundle:Routes')->findAllRoot('id');

        $maps = $this->em->getRepository('EsterenMapsBundle:Maps')->findAllRoot('id');
        $factions = $this->em->getRepository('EsterenMapsBundle:Factions')->findAllRoot('id');
        $markersTypes = $this->getReferenceObjects('markertype', 'EsterenMapsBundle:MarkersTypes', 'id_marker');
        $zonesTypes = $this->getReferenceObjects('zonetype', 'EsterenMapsBundle:ZonesTypes', 'id_zonetype');
        $routesTypes = $this->getReferenceObjects('routetype', 'EsterenMapsBundle:RoutesTypes', 'id_route');

        $inputMarkers = array();
        $inputMarkersTypes = array();
        $inputZones = array();
        $inputRoutes = array();

        $unknownTypes = array();

        $numb = 0;
        $total = count($datas);

        $exceptionMessages = '';

        $output->writeln('Found <info>'.$total.'</info> items to check for import.');

        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
            $output->writeln('First character:');
            $output->writeln(' <comment>M</comment>: Markers');
            $output->writeln(' <comment>R</comment>: Routes');
            $output->writeln(' <comment>Z</comment>: Zones');
            $output->writeln(' <comment>E</comment>: An error occurred');
            $output->writeln(' <comment>_</comment>: Unknown type');
            $output->writeln('Second character:');
            $output->writeln(' <comment>i</comment>: Insert');
            $output->writeln(' <comment>u</comment>: Update');
        }

        $output->writeln('Processing...');

        foreach ($datas as $data) {
            $numb++;

            $status = ' ';

            $type = $data['tags'];
            $id = isset($data['id']) ? $data['id'] : null;
            $created = DateTime::createFromFormat('YmdHisu', isset($data['created']) ? $data['created'] : date('YmdHisu'));
            $modified = DateTime::createFromFormat('YmdHisu', isset($data['modified']) ? $data['modified'] : date('YmdHisu'));
            $title = $data['title'];
            $text = $data['text'];

            try {
                $object = null;
                /** @var Markers|Zones|Routes $object */
                switch ($type) {
                    case 'marqueurs':
                        $status .= 'M';
                        $object = isset($dbMarkers[$id]) ? $dbMarkers[$id] : new Markers;

                        if (isset($markersTypes[$data['markertype_id']])) {
                            $markerType = $markersTypes[$data['markertype_id']];
                        } else {
                            $markerType = new MarkersTypes();
                            $markerType->setName(str_replace('id_marker', '', $data['markertype_id']));
                            $markerType->setDescription('');
                            $inputMarkersTypes[] = $markerType;
                        }

                        $object
                            ->setName($title)
                            ->setDescription($text)
                            ->setFaction($factions[$data['faction_id']])
                            ->setMap($maps[$data['map_id']])
                            ->setMarkerType($markerType)
                            ->setCreatedAt($created)
                            ->setUpdatedAt($modified)
                        ;
                        if (!$object->isLocalized()) {
                            $object->setLatitude(0)->setLongitude(0);
                        }
                        if (!$object->getId()) {
                            $inputMarkers[$id] = $object;
                        }
                        $this->em->persist($object);
                        break;
                    case 'zones':
                        $status .= 'Z';
                        $object = isset($dbZones[$id]) ? $dbZones[$id] : new Zones;
                        break;
                    case 'routes':
                        $status .= 'R';
                        $object = isset($dbRoutes[$id]) ? $dbRoutes[$id] : new Routes;
                        break;
                    default:
                        $unknownTypes[$type] = null;
                        $status .= '_';
                        break;
                }
                $status .= $object && $object->getId() ? 'u' : 'i';
            } catch (\Exception $e) {
                $status .= 'E';
                $exceptionMessages .= "\n".$e->getFile().':'.$e->getLine()."    ".$e->getMessage();
            }
            $output->write($status);
            if (($numb % 20 === 0 || $numb === $total) && $numb) {
                $percent = ((int) ($numb * 100 / $total)).'%';
                if ($numb === $total) {
                    $percent = str_pad($percent, 60, ' ', STR_PAD_RIGHT);
                }
                $output->write(' '.$percent."\n");
            }

        } // end foreach

        if (count($unknownTypes)) {
            $exceptionMessages .= "\nUnknown Types:\n".(implode(', ', array_keys($unknownTypes)));
        }

        if ($exceptionMessages) {
            throw new \RuntimeException($exceptionMessages);
        }
    }

    /**
     * @param string $dataTag
     * @param string $entity
     * @param string $idToReplace
     * @param string $nameProperty
     *
     * @return \object[]
     */
    protected function getReferenceObjects($dataTag, $entity, $idToReplace, $nameProperty = 'name')
    {
        $datas = array_filter($this->datas, function($element) use ($dataTag) {
            return isset($element['tags']) && $element['tags'] === $dataTag;
        });

        /** @var BaseEntityRepository $repo */
        $repo = $this->em->getRepository($entity);

        $objects = $repo->findAllRoot('id');

        foreach ($datas as $data) {
            if (strpos($data['id'], $idToReplace) === 0) {
                $exists = $repo->findOneBy(array($nameProperty => $data['title']));
                if (!$exists) {
                    dump('does not exist', $data);
                    $object = new MarkersTypes();
                    $object->{'set'.ucfirst($nameProperty)}($data['title']);
                    $this->em->persist($object);
                    $this->em->flush($object);
                    $objects[$object->getId()] = $object;
                    $this->output->writeln('Added new object of type <comment>'.$entity.'</comment> with name <comment>'.$object->getName().'</comment>');
                }
            }
        }

        return $objects;
    }

}
