<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Command;

use EsterenMaps\MapsBundle\Entity\Maps;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MapTilesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('esterenmaps:map:generate-tiles')
            ->setDescription('Generate all tiles for a specific map.')
            ->setHelp('This command is used to generate a tile image for one of your maps.'."\n"
                .'You can specify the id of the map by adding it as an argument, or as an option with "-i x" or "--i=x" where "x" is the map id'."\n"
                ."\n".'The command will generate all tiles of a map. The tiles number is calculated upon the image size and the maxZoom value'
                ."\n".'The higher is the maxZoom value, higher is the number of tiles.'
                ."\n".'This command can take a long time to execute, depending of your system.'
                ."\n".'but do not worry : you can restart it at any time and skip all existing files')
            ->addArgument('id', InputArgument::OPTIONAL, 'Enter the id of the map you want to generate', null)
            ->addOption('replace', 'r', InputOption::VALUE_NONE, 'Replaces all existing tiles')
            ->addOption('skip', 'k', InputOption::VALUE_NONE, 'Skip all existing tiles')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $id = $input->hasArgument('id') ? $input->getArgument('id') : null;

        /** @var BaseEntityRepository $repo */
        $repo = $this->getContainer()->get('doctrine')->getManager()->getRepository('EsterenMapsBundle:Maps');

        $list = null;

        $io->comment('Be careful: as maps may be huge, this application can use a lot of memory and take very long to execute.');

        /** @var Maps $map */
        $map = null;

        do {
            // Finds a map
            $map = $repo->findOneBy(['id' => $id]);

            // If no map is found, we'll ask the user to choose between any of the maps in the database
            if (!$map) {
                $maps_list = [];
                if ($list === null) {

                    /* @var Maps[] $list */
                    $maps_list = $repo->findAllRoot('id');

                    if (!count($maps_list)) {
                        $io->comment('There is no map in the database.');

                        return 1;
                    }

                    unset($list);
                }
                if ($id !== null) {
                    $io->warning('No map with id: '.$id);
                }
                $id = $io->choice('Select a map to generate:', $maps_list);
            }
        } while (!$map);

        $io->comment('Generating map tiles for "'.$map->getName().'"');

        $tilesManager = $this->getContainer()->get('esterenmaps')->getTilesManager();

        // This is a workaround to allow images to be stored with either global path or relative path
        if (!file_exists($map->getImage())) {
            $img = $this->getContainer()->getParameter('kernel.root_dir').'/../web/'.$map->getImage();
            $map->setImage($img);
        }

        if (!file_exists($map->getImage())) {
            throw new \RuntimeException('Map image cannot be found.');
        }

        try {
            for ($i = 0; $i <= $map->getMaxZoom(); ++$i) {
                $io->comment('Processing extraction for zoom value '.$i);
                $tilesManager->generateTiles($i, true, $map);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException('Error while processing extraction for zoom value "'.(isset($i) ? $i : '0').'".', 1, $e);
        }

        return 0;
    }
}
