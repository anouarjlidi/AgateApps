<?php

namespace EsterenMaps\MapsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MapTileCommand extends ContainerAwareCommand
{
    /**
     * Static var to use in validators.
     *
     * @var int
     */
    public static $xmax;

    /**
     * Static var to use in validators.
     *
     * @var int
     */
    public static $ymax;

    /**
     * Static var to use in validators.
     *
     * @var int
     */
    public static $zoom;

    protected function configure()
    {
        $this
            ->setName('esterenmaps:map:generate-one-tile')
            ->setDescription('Generate one tile for a specific map.')
            ->setHelp('This command is used to generate a tile image for one of your maps.'."\n"
                .'You can specify the id of the map by adding it as an argument, or as an option with "-i x" where "x" is the map id'."\n"
                ."\n".'The command will generate a tile with three mandatory options:'
                ."\n".'x => the "x" value of the tile, from left to right, starting at 0'
                ."\n".'y => the "y" value of the tile, from top to bottom, starting at 0'
                ."\n".'zoom (or -z) => the zoom value used to generate the tile, starting at 0'
                ."\n\n".'You can also use the --replace command to overwrite any existing tile.')
            ->addArgument('id', InputArgument::OPTIONAL, 'Enter the id of the map you want to generate')
            ->addOption('id', 'i', InputOption::VALUE_OPTIONAL, 'Enter the id of the map you want to generate', null)
            ->addOption('x', 'x', InputOption::VALUE_OPTIONAL, 'Determines the "x" value of the tile', null)
            ->addOption('y', 'y', InputOption::VALUE_OPTIONAL, 'Determines the "y" value of the tile', null)
            ->addOption('zoom', 'z', InputOption::VALUE_OPTIONAL, 'Determines the "zoom" value of the tile', null)
            ->addOption('replace', 'r', InputOption::VALUE_NONE, 'Replaces the tile if it already exists')
            ->addOption('no-interaction', 'n', InputOption::VALUE_NONE, 'No interaction (used by controllers)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<error>Not implemented anymore, needs refactoring...</error>');

        return 2;

        /*

        $id   = $input->getArgument('id') ? : ($input->getOption('id') ? : null);
        $x    = $input->getOption('x');
        $y    = $input->getOption('y');
        $zoom = $input->getOption('zoom');

        $interaction = $input->getOption('no-interaction');

        //Récupération du service "dialog" pour les demandes à l'utilisateur
        $interaction = !!$this->getHelperSet();
        if ($interaction) {
            $dialog = $this->getHelperSet()->get('dialog');
        }

        $repo = $this->getContainer()->get('doctrine')->getManager()->getRepository('EsterenMapsBundle:Maps');

        $list = null;

        $sleep = 50000;

        $output->writeln('   ______                     __                   ____   _      ');
        $output->writeln('  / ____/____   _____ ____ _ / /_   ____          / __ \\ (_)____ ');
        $output->writeln(' / /    / __ \\ / ___// __ `// __ \\ / __ \\ ______ / /_/ // // __ \\');
        $output->writeln('/ /___ / /_/ // /   / /_/ // / / // / / //_____// _, _// // / / /');
        $output->writeln('\\____/ \\____//_/    \\__,_//_/ /_//_/ /_/       /_/ |_|/_//_/ /_/ ');
        $output->writeln('');

        $output->writeln('Welcome to Corahn-Rin map tile generator !');
        $output->writeln('With this command, you will be able to generate tiles one by one for a specific map.');
        $output->writeln('');

        $map = null;

        // Recherche de la carte
        do {
            $map = $repo->findOneBy(array('id' => $id));
            if (!$map) {
                if ($list === null) {//Création de la liste si jamais un mauvais id est entré
                    $list = $repo->findAll();

                    $maps_list = array();
                    foreach ($list as $v) {
                        $maps_list[$v->getId()] = $v->getName();
                    }
                    unset($list);
                }
                $output->writeln('No map with this id.');
                $id = $dialog->select(
                    $output,
                    'Select a map to generate:',
                    $maps_list,
                    false,
                    false,
                    'No id "%s" in maps list.'
                );
            }
        } while (!$map);

        $output->writeln('Generating map tile for "'.$map->getName().'"');

        // Récupération du paramètre "tile_size" du bundle
        $img_size = (int) $this->getContainer()->getParameter('esterenmaps.tile_size');

        // Création du tilesManager
        $tilesManager = new MapsTileManager($map, $img_size);
        //TODO : Refaire ce système pour s'adapter au nouveau service

        // Récupération d'une valeur correcte du zoom
        self::$zoom = $map->getMaxZoom();
        if ($zoom < 0 || $zoom > $map->getMaxZoom() || null === $zoom) {
            $zoom = $dialog->askAndValidate($output,
                'Enter a correct zoom value between 0 and '.$map->getMaxZoom().":\n>",
                function ($z) {
                    $z = (int) $z;
                    if ($z >= 1 && $z <= MapTileCommand::$zoom) {
                        return $z;
                    } else {
                        throw new \RunTimeException('Value must be between 0 and '.MapTileCommand::$zoom);
                    }
                });
        }
        if (3 <= $output->getVerbosity()) {
            $output->writeln('Zoom value of '.$zoom);
        }

        $identification = $tilesManager->identifyImage($zoom);

        if (2 <= $output->getVerbosity()) {
            $output->writeln('Maximum size of '.$identification['xmax'].'x'.$identification['ymax'].' tiles');
        }
        if (2 <= $output->getVerbosity()) {
            $output->writeln('Crop unit : '.(1 + ($map->getMaxZoom() - $zoom)) * $img_size);
        }
        if (3 <= $output->getVerbosity()) {
            $output->writeln('Maximum size of '.$identification['wmax'].'x'.$identification['hmax'].' pixels');
        }

        //Récupération de la valeur correcte de X et Y
        self::$xmax = $identification['xmax'];
        self::$ymax = $identification['ymax'];
        if (2 <= $output->getVerbosity()) {
            $output->writeln('Retrieving correct X and Y values');
        }
        if (!is_numeric($x) || $x < 0 || $x > $identification['xmax']) {
            $x = $dialog->askAndValidate($output,
                'Enter a correct "x" value between 0 and '.$identification['xmax'].":\n>",
                function ($z) {
                    $z = (int) $z;
                    if ($z >= 0 && $z <= MapTileCommand::$xmax) {
                        return $z;
                    } else {
                        throw new \RunTimeException('Value must be between 0 and '.MapTileCommand::$xmax);
                    }
                });
        }
        if (!is_numeric($y) || $y < 0 || $y > $identification['ymax']) {
            $y = $dialog->askAndValidate($output,
                'Enter a correct "y" value between 0 and '.$identification['ymax'].":\n>",
                function ($z) {
                    $z = (int) $z;
                    if ($z >= 0 && $z <= MapTileCommand::$ymax) {
                        return $z;
                    } else {
                        throw new \RunTimeException('Value must be between 0 and '.MapTileCommand::$ymax);
                    }
                });
        }
        if (2 <= $output->getVerbosity()) {
            $output->writeln('Coordinates of the tile : ('.$x.', '.$y.')');
        }
        if (2 <= $output->getVerbosity()) {
            $output->writeln('Filename: '.$tilesManager->mapDestinationName($zoom, $x, $y));
        }

        $overwrite = $input->getOption('replace');
        $exists    = file_exists($tilesManager->mapDestinationName($zoom, $x, $y));
        if ($exists && !$overwrite) {
            $choices  = array('yes', 'no');
            $answer   = $dialog->select(
                $output,
                'Following file already exists: '."\n".'> '.
                str_replace(ROOT.DS, '', $tilesManager->mapDestinationName($zoom, $x, $y)).
                "\n".'Overwrite ? [yes]',
                $choices,
                0,
                false,
                'Answer "%s" is not correct'
            );
            $selected = $choices[$answer];
            if ($selected === 'yes') {
                $output->writeln('Overwriting');
                $overwrite = true;
            } elseif ($selected === 'no') {
                $output->writeln('File exists and you do not want to overwrite it');
                $overwrite = false;
            }
        } else {
            if ($overwrite) {
                $output->writeln('Parameter "--replace" specified, overwriting');
            }
            $overwrite = true;
        }

        if ($overwrite) {
            if (2 <= $output->getVerbosity()) {
                $time = microtime(true);
                $output->writeln('Executing tiles manager command');
            }
            $cmd_output = $tilesManager->createTile($x, $y, $zoom, true);
            if (3 <= $output->getVerbosity()) {
                $output->writeln('Executing following command :');
                $output->writeln($cmd_output);
            }
            $cmd_output = shell_exec($cmd_output);
            if (2 <= $output->getVerbosity()) {
                $time = microtime(true) - $time;
                $time = number_format($time * 1000, 2, '.', ',');
                $output->writeln('Execution time of '.$time.' milliseconds');
            }
            if ($cmd_output) {
                $output->writeln('Error in the ImageMagick command:');
                $output->writeln($cmd_output);
            } else {
                $output->writeln('File written correctly');
            }

        }

        $output->writeln('End of function');
        $output->writeln('Thanks for using CorahnRin, and see you soon !');
        */
    }
}
