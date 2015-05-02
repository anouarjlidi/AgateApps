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
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportTiddlyWikiCommand extends ContainerAwareCommand
{

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
         * @var EntityManager $em
         */
        $em = $this->getContainer()->get('doctrine')->getManager();

        /** @var Markers[] $markers */
        /** @var Zones[] $zones */
        /** @var Routes[] $routes */
        /** @var Maps[] $maps */
        /** @var Factions[] $factions */
        /** @var MarkersTypes[] $markersTypes */
        /** @var ZonesTypes[] $zonesTypes */
        /** @var RoutesTypes[] $routesTypes */
        $markers = $em->getRepository('EsterenMapsBundle:Markers')->findAllRoot('id');
        $zones = $em->getRepository('EsterenMapsBundle:Zones')->findAllRoot('id');
        $routes = $em->getRepository('EsterenMapsBundle:Routes')->findAllRoot('id');

        $maps = $em->getRepository('EsterenMapsBundle:Maps')->findAllRoot('id');
        $factions = $em->getRepository('EsterenMapsBundle:Factions')->findAllRoot('id');
        $markersTypes = $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAllRoot('id');
        $zonesTypes = $em->getRepository('EsterenMapsBundle:ZonesTypes')->findAllRoot('id');
        $routesTypes = $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAllRoot('id');

        $inputMarkers = array();
        $inputZones = array();
        $inputRoutes = array();

        $numb = 0;
        $total = count($datas);

        $exceptionMessages = '';

        $output->writeln('Found <info>'.$total.'</info> items to check for import.');
        foreach ($datas as $data) {
            $numb++;

            $status = ' ';

            $type = $data['tags'];
            $id = $data['id'];
            $created = DateTime::createFromFormat('YmdHisu', $data['created']);
            $modified = DateTime::createFromFormat('YmdHisu', $data['modified']);
            $title = $data['title'];
            $text = $data['text'];

            try {
                $object = null;
                /** @var Markers|Zones|Routes $object */
                switch ($type) {
                    case 'marqueurs':
                        $status .= 'M';
                        $object = isset($dbMarkers[$id]) ? $dbMarkers[$id] : new Markers;
                        $object
                            ->setName($title)
                            ->setDescription($text)
                            ->setFaction($factions[$data['faction_id']])
                            ->setMap($maps[$data['map_id']])
                            ->setMarkerType($markersTypes[$data['markertype_id']])
                            ->setCreatedAt($created)
                            ->setUpdatedAt($modified)
                        ;
                        if (!$object->isLocalized()) {
                            $object->setLatitude(0)->setLongitude(0);
                        }
                        if (!$object->getId()) {
                            $inputMarkers[$id] = $object;
                        }
                        $em->persist($object);
                        break;
                    case 'zones':
                        $status .= 'Z';
                        $object = isset($dbZones[$id]) ? $dbZones[$id] : new Zones;
                        break;
                    case 'routes':
                        $status .= 'Z';
                        $object = isset($dbRoutes[$id]) ? $dbRoutes[$id] : new Routes;
                        break;
                    default:
                        $output->writeln('<error>Unknown type: '.$type.'</error>');
                        $status .= '_';
                        continue;
                }
                $status .= $object->getId() ? 'u' : 'i';
            } catch (\Exception $e) {
                $status .= 'E';
                $exceptionMessages .= "\n\t".get_class($e)."\t".(isset($object) && $object ? get_class($object) : '')."\t".$e->getLine().':'.$e->getMessage();
            }
            $output->write($status);
            if (($numb % 20 === 0 || $numb === $total) && $numb) {
                $percent = ((int) ($numb * 100 / $total)).'%';
                if ($numb === $total) {
                    $percent = str_pad($percent, 60, ' ', STR_PAD_RIGHT);
                }
                $output->write(' '.$percent."\n");
            }

        }

        if ($exceptionMessages) {
            $output->writeln("<error>\n$exceptionMessages\n</error>");
        }
    }

}
