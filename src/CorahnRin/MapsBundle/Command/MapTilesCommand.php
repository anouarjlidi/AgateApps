<?php
namespace CorahnRin\MapsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CorahnRin\MapsBundle\Classes\MapsTileManager;

class MapTilesCommand extends ContainerAwareCommand {

	protected function configure() {

		//public function addArgument($name, $mode = null, $description = '', $default = null)
		$this
		->setName('corahnrin:generate:map-tiles')
		->setDescription('Generate all tiles for a specific map.')
		->setDescription('Generate all tiles for a specific map.')
        ->setHelp('This command is used to generate a tile image for one of your maps.'."\n"
            .'You can specify the id of the map by adding it as an argument, or as an option with "-i x" or "--i=x" where "x" is the map id'."\n"
            ."\n".'The command will generate all tiles of a map. The tiles number is calculated upon the image size and the maxZoom value'
            ."\n".'The higher is the maxZoom value, higher is the number of tiles.'
            ."\n".'This command can take a long time to execute, depending of your system.'
            ."\n".'but do not worry : you can restart it at any time and skip all existing files')
		->addArgument('id', InputArgument::OPTIONAL, 'Enter the id of the map you want to generate')
        ->addOption('id', 'i', InputOption::VALUE_OPTIONAL, 'Enter the id of the map you want to generate', null)
        ->addOption('replace', 'r', InputOption::VALUE_NONE, 'Replaces all existing tiles')
        ->addOption('skip', 'k', InputOption::VALUE_NONE, 'Skip all existing tiles')
        ;
	}

	protected function execute(InputInterface $input, OutputInterface $output) {

        $id = $input->getArgument('id') ?: ($input->getOption('id') ?: null);

        $global_time = microtime(true);
		//Récupération du service "dialog" pour les demandes à l'utilisateur
		$dialog = $this->getHelperSet()->get('dialog');

        $repo = $this->getContainer()->get('doctrine')->getManager()->getRepository('CorahnRinMapsBundle:Maps');

        $list = null;

        $sleep = 50000;

        $output->writeln('   ______                     __                   ____   _      ');
        $output->writeln('  / ____/____   _____ ____ _ / /_   ____          / __ \\ (_)____ ');
        $output->writeln(' / /    / __ \\ / ___// __ `// __ \\ / __ \\ ______ / /_/ // // __ \\');
        $output->writeln('/ /___ / /_/ // /   / /_/ // / / // / / //_____// _, _// // / / /');
        $output->writeln('\\____/ \\____//_/    \\__,_//_/ /_//_/ /_/       /_/ |_|/_//_/ /_/ ');
        $output->writeln('');

		$output->writeln('Welcome to Corahn-Rin map tiles generator !'); usleep($sleep);
		$output->writeln('Be careful : as maps may be huge, this application can use a lot of memory and take very long to execute.');
		$output->writeln('You can stop the process with no problem, as you can decide to skip or overwrite all existing images.');usleep($sleep);
		$output->writeln('');

        $map = null;
        // Recherche de la carte
        do {
            $map = $repo->findOneBy(array('id'=>$id));
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

		$output->writeln('Generating map tiles for "'.$map->getName().'"');


        $cmd = 'identify -format "%wx%h" "'.ROOT.'/web/'.$map->getImage().'"';
        $size = shell_exec($cmd);
        if (!$size || !preg_match('#^[0-9]+x[0-9]+$#', $size)) {
            throw new \RunTimeException('Error while retrieving map dimensions.');
        }
        list($w, $h) = explode('x',$size);

        // Récupération du paramètre "tile_size" du bundle
        $img_size = (int) $this->getContainer()->getParameter('corahn_rin_maps.tile_size');

        // Création du tilesManager
        $tilesManager = new MapsTileManager($map, $img_size);

        $files_written = 0;
		$overwrite_all = (int) $input->getOption('replace');
        $skip = $input->getOption('skip');
        if ($skip) { $overwrite_all = 2; }

        $total_files = 0;
        $current_file = 0;

        //Création de la liste des identifications
        //Calcul du nombre total de vignettes à créer
        for ($zoom = 0; $zoom <= $map->getMaxZoom(); $zoom++) {
            $identifications[$zoom] = $tilesManager->identifyImage($zoom);
            $total_files += $identifications[$zoom]['tiles_max'];
        }

        $times = array();

        for ($zoom = 0; $zoom <= $map->getMaxZoom(); $zoom++) {
            $identification = $identifications[$zoom];

//            $total_files = ($xmax+1)*($ymax+1);
            for ($x = 0; $x < $identification['xmax']; $x++) {
                for ($y = 0; $y < $identification['ymax']; $y++) {
                    $time = microtime(true);
                    $current_file++;
        			$overwrite = $input->getOption('replace');
        			$exists = file_exists($tilesManager->mapDestinationName($zoom, $x, $y));
        			if ($exists && !$overwrite) {
        				if ($overwrite_all === 0) {
        					$choices = array('yes','yes to all','no','no to all');
        					$answer = $dialog->select(
        						$output,
                                'Following file already exists : '."\n".'> '.$tilesManager->mapDestinationName($zoom, $x, $y). "\n". 'Overwrite ? [yes]',
        						$choices,
        						0,
        						false,
        						'Answer "%s" is not correct'
        					);

                            $selected = $choices[$answer];
        					if ($selected === 'yes') {
        						$overwrite = true;
        					} elseif ($selected === 'yes to all') {
        						$overwrite = true;
        						$overwrite_all = 1;
        					} elseif ($selected === 'no') {
        						$overwrite = false;
        					} elseif ($selected === 'no to all') {
        						$overwrite = false;
        						$overwrite_all = 2;
        					}
        				} elseif ($overwrite_all === 1) {
        					$overwrite = true;
        				} elseif ($overwrite_all === 2) {
        					$overwrite = false;
        				}
        			} else {
        				$overwrite = true;
        			}

                    if ($overwrite) {
                        $files_written++;
                        //Commande ImageMagick
                        $cmd = $tilesManager->createTile($x, $y, $zoom, true);
                        shell_exec($cmd);
//                        $output->writeln($cmd);
//                        $cmd = 'convert'.
//                                ' "'.ROOT.'/web/'.$map->getImage().'"'.
//                                ($ratio < 1 ? ' -resize '.($ratio*100) .'%' : '').
//                                ' -background black'.//Le "surplus" sera noirs
//                                ' -extent '.$wmax.'x'.$hmax.'^'.//Redimensionne aux valeurs "width" et "height" maximales dépendant du zoom
//                                ' -crop '.$img_size.'x'.$img_size.'+'.$_x.'+'.$_y.//Découpe l'image selon la taille demandée dans les paramètres
//                                ' -extent '.$img_size.'x'.$img_size.'^'.//Et étend les éventuels pixels en trop ou en moins
//                                ' -quality 95'.//Une faible qualité réduira le poids des images
//                                ' -thumbnail '.$img_size.'x'.$img_size.
//                                ' "'.$imgname.'"';
//                        shell_exec($cmd);
                    }

                    $p = ($current_file * 100 / $total_files);
                    $p = number_format($p, 2, '.', '');
                    $str = 0;
                    $str = '[';
                    $p2 = (int)($p/2);
                    for ($i = 0; $i <= 50; $i++) {
                        $str .= $p2 < $i ? ' ' : ($p2 === $i ? ($current_file % 2 === 0 ? '>' : '=') : '=');
                    }
                    $str .= ']';
                    $time = microtime(true) - $time;
                    if ($overwrite) {
                        $times[] = $time;
                    }
                    if (count($times)) {
                        $median = array_sum($times) / count($times);
                    } else {
                        $median = 60*60*24*365;
                    }
                    $time_remaining = gmdate("H:i:s", $median * ($total_files - $current_file));
                    $remaining = '  Remaining: '.$time_remaining.' (estimation)';
                    $spent = ' Spent: '.gmdate('H:i:s', microtime(true) - $global_time);
                    $output->write(' '.$str." ".$p.'% File '.$current_file.'/'.$total_files.' x='.$x.' y='.$y.' z='.$zoom.$remaining.$spent." \r");
                }
            }
        }

        $output->writeln("\n");
		$output->writeln('End of function !');
        $output->writeln($files_written.' files have been written !');
        $output->writeln('Execution time : '.gmdate('H:i:s', microtime(true) - $global_time));
		$output->writeln('Thanks for using CorahnRin, and see you soon !');

	}
}