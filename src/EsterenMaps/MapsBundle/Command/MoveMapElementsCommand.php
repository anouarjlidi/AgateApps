<?php

namespace EsterenMaps\MapsBundle\Command;

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\ProgressHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MoveMapElementsCommand extends ContainerAwareCommand
{

    /**
     * @var float
     */
    private $scale;

    /**
     * @var float
     */
    private $scaleAfter;

    public function configure()
    {
        $this
            ->setName('esterenmaps:map:move-elements')
            ->setDescription('Moves all maps elements depending on coordinates.')
            ->setHelp(
                'This command moves all elements of the map, including routes, markers and zones,'."\n".
                'depending on coordinates you specify: latitude, longitude and scale.'."\n\n".
                'Example:'."\n".
                '$ php bin/console '.$this->getName().' --latitude="<info>-1.4</info>" --longitude="<info>8.7</info>" --scale="1.50"'."\n".
                'The above command will first <info>widen</info> all elements by <info>1.5%</info>, '.
                'then move every element <info>1.4 degrees to the south</info>, and <info>8.7 degrees to the east</info>.'."\n\n".
                '<comment>Note:</comment> be very careful with negative values. You must proprly use the "=" sign'."\n".
                'and wrap the number with quotes, or Symfony will think you added another parameter'."\n".
                'to the command.'."\n"
            )
            ->addArgument('map', InputArgument::OPTIONAL, 'The map ID you want to update.')
            ->addOption('latitude', null, InputOption::VALUE_OPTIONAL, 'The latitude offset you want your elements to move. (can be negative)', '0')
            ->addOption('longitude', null, InputOption::VALUE_OPTIONAL, 'The longitude offset you want your elements to move. (can be negative)', '0')
            ->addOption('scale', null, InputOption::VALUE_OPTIONAL, 'The scale of the movement, in percentage. Can be negative, and superior to 100 (or inferior to -100).'."\n".'<comment>Note:</comment> The scaling will occur BEFORE moving the elements.', '0')
            ->addOption('scale-after', null, InputOption::VALUE_NONE, 'If specified, the scaling will occur AFTER moving the elements')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->hasArgument('map') ? $input->getArgument('map') : null;

        /** @var DialogHelper $dialog */
        $dialog = $this->getHelperSet()->get('dialog');

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        /** @var BaseEntityRepository $repo */
        $repo = $em->getRepository('EsterenMapsBundle:Maps');

        $list = null;

        $latitude = (float) $input->getOption('latitude');
        $longitude = (float) $input->getOption('longitude');
        $this->scale = (float) $input->getOption('scale');
        $this->scaleAfter = (bool) $input->getOptions('scale-after');

        if (!$latitude && !$longitude && !$this->scale) {
            $output->writeln('No datas specified. Please read the help by running this command with "--help" or "-h".');
            return 1;
        }

        /** @var Maps $map */
        $map = null;
        if ($input->getOption('no-interaction') && !$id) {
            throw new \RuntimeException('You must specify a map.');
        }

        do {
            $map = $repo->findOneBy(array('id'=>$id));
            if (!$map) {
                $maps_list = array();
                if ($list === null) {
                    /** @var Maps[] $list */
                    $list = $repo->findAll();
                    foreach ($list as $v) {
                        $maps_list[$v->getId()] = $v->getName();
                    }
                    unset($list);
                }
                if ($id !== null) {
                    $output->writeln('<comment>No map with id "'.$id.'".</comment>');
                }
                $id = $dialog->select(
                    $output,
                    '<question>Select a map to update:</question>',
                    $maps_list,
                    false,
                    false,
                    'No id "%s" in maps list.'
                );
            }
        } while (!$map);

        $output->writeln("Map to update: <info>$map</info>");

        if ($latitude) {
            $output->writeln("Latitude to move: <info>$latitude</info> (to ".($latitude>0?'North':'South').')');
        }

        if ($longitude) {
            $output->writeln("Longitude to move: <info>$longitude</info> (to ".($longitude>0?'East':'West').')');
        }

        if ($this->scale) {
            $output->writeln("Scale to apply: <info>{$this->scale}</info> (".($this->scaleAfter?'after':'before').")");
        }

        $numberOfElements = count($map->getMarkers()) + count($map->getRoutes()) + count($map->getZones());

        $run = $dialog->askConfirmation($output, "Found <info>$numberOfElements</info> elements.\n".'<question>Execute? [Y/n]</question>', true);

        if (!$run) {
            return 1;
        }

        /** @var ProgressHelper $progress */
        $progress = $this->getHelper('progress');
        $progress->start($output, $numberOfElements);

        foreach ($map->getZones() as $zone) {
            $coordinates = $zone->getDecodedCoordinates();
            foreach ($coordinates as $k => $latlng) {
                $coordinates[$k]['lat'] = $this->computeValue($latlng['lat'], $latitude);
                $coordinates[$k]['lng'] = $this->computeValue($latlng['lng'], $longitude);
            }
            $zone->setCoordinates(json_encode($coordinates));
            $em->persist($zone);
            $progress->advance();
        }

        foreach ($map->getRoutes() as $route) {
            $coordinates = $route->getDecodedCoordinates();
            foreach ($coordinates as $k => $latlng) {
                $coordinates[$k]['lat'] = $this->computeValue($latlng['lat'], $latitude);
                $coordinates[$k]['lng'] = $this->computeValue($latlng['lng'], $longitude);
            }
            $route->setCoordinates(json_encode($coordinates));
            $em->persist($route);
            $progress->advance();
        }

        foreach ($map->getMarkers() as $marker) {
            $marker->setLatitude($this->computeValue($marker->getLatitude(), $latitude));
            $marker->setLongitude($this->computeValue($marker->getLongitude(), $longitude));

            $em->persist($marker);
            $progress->advance(1, true);
        }

        $progress->finish();

        $em->flush();

        return 0;
    }

    /**
     * @param float   $initialValue
     * @param float   $reference
     *
     * @return float
     */
    private function computeValue($initialValue, $reference)
    {
        $value = (float) $initialValue;

        if (!$this->scaleAfter) { $value += $value * ($this->scale / 100); }

        $value += $reference;

        if ($this->scaleAfter) { $value += $value * ($this->scale / 100); }

        return $value;
    }

}

// DATAS

//   82.74690205692
// -138,71484406292
//
//   81.30832090051
// -129,94628906250
//
//   -1.43858115641
//    8.76855500042

// 79,22897540022
// 25,0048828125
//
// 77,10823083404757
// 33,57421875
//
// -2,12074446617243
//  8,5693359375


// Command :
// ./reset.bash && bin/console d:q:s "`cat _dev_files/position_unclean_elements.sql`" && bin/console esterenmaps:refresh-datas && bin/console esterenmaps:move-map-elements 1 --latitude="-2.12074446617243" --longitude="8.5693359375" --no-interaction -v && php bin/console esterenmaps:refresh-datas
