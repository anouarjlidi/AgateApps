<?php
namespace CorahnRin\MapsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MapCommand extends ContainerAwareCommand {

	protected function configure() {

		//public function addArgument($name, $mode = null, $description = '', $default = null)
		$this
		->setName('corahnrin:generate:map')
		->setDescription('Generate all files for a specific map.')
		->addArgument('id', InputArgument::OPTIONAL, 'Enter the id of the map you want to generate');
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
        $global_time = microtime(true);
		//Récupération du service "dialog" pour les demandes à l'utilisateur
		$dialog = $this->getHelperSet()->get('dialog');
        
        $repo = $this->getContainer()->get('doctrine')->getManager()->getRepository('CorahnRinMapsBundle:Maps');

        $list = $repo->findAll();
        
        $maps_list = array();
        foreach ($list as $v) {
            $maps_list[$v->getId()] = $v->getName();
        }
        unset($list);
        
        $sleep = 50000;
        
		$output->writeln('Welcome to Corahn-Rin map generator !'); usleep($sleep);
		$output->writeln('Be careful : as maps may be huge, this application can use a lot of memory and take very long to execute.');
		$output->writeln('Be sure not to stop the process, as it starts by zero on each execution.');usleep($sleep);
		$output->writeln('');
        
        $map = null;
		$id = (int) $input->getArgument('id');
        do {
            $map = $repo->findOneBy(array('id'=>$id));
            if (!$map) {
                $output->writeln('No map with this id.');
                $id = $dialog->select(
                    $output,
                    'Select a map to generate :',
                    $maps_list,
                    false,
                    false,
                    'No id "%s" in maps list.'
                );
            }
        } while (!$map);
        
		$output->writeln('Generating map "'.$map->getName().'"');

        $cmd = 'identify -format "%wx%h" "'.ROOT.'/web/'.$map->getImage().'"';
        $size = shell_exec($cmd);
        if (!$size || !preg_match('#^[0-9]+x[0-9]+$#', $size)) {
            throw new \RunTimeException('Error while retrieving map dimensions.');
        }
        list($w, $h) = explode('x',$size);

        $img_size = (int) $this->getContainer()->getParameter('corahn_rin_maps.tile_size');;

        $files_written = 0;
		$overwrite_all = 0;
       
        $total_files = 0;
        $current_file = 0;
        
        for ($zoom = 1; $zoom <= $map->getMaxZoom(); $zoom++) {
            $ratio = $zoom / $map->getMaxZoom();
            $_w = (int) $w * $ratio;
            $_h = (int) $h * $ratio;
            $xmax = $_w / $img_size;
            $ymax = $_h / $img_size;
            if ((int)$xmax < $xmax) { $xmax = ((int) $xmax) + 1; }
            if ((int)$ymax < $ymax) { $ymax = ((int) $ymax) + 1; }
            $total_files += ($xmax)*($ymax);
        }

        $times = array();

        for ($zoom = 1; $zoom <= $map->getMaxZoom(); $zoom++) {
            $ratio = $zoom / $map->getMaxZoom();
            $_w = (int) $w * $ratio;
            $_h = (int) $h * $ratio;

            //Calcul du nombre maximum de vignettes
            $xmax = $_w / $img_size;
            $ymax = $_h / $img_size;

            if ((int)$xmax < $xmax) { $xmax = ((int) $xmax) + 1; }
            if ((int)$ymax < $ymax) { $ymax = ((int) $ymax) + 1; }

            $wmax = $xmax * $img_size;
            $hmax = $ymax * $img_size;

//            $total_files = ($xmax+1)*($ymax+1);
            for ($x = 0; $x < $xmax; $x++) {
                for ($y = 0; $y < $ymax; $y++) {
                    $time = microtime(true);
                    $current_file++;
                    //Génération du nom de la tuile finale (dans le cache)
                    $imgname = ROOT.'/app/cache/maps_img/'.$map->getNameSlug().'_'.$zoom.'_'.$x.'_'.$y.'.jpg';
                    if (!is_dir(dirname($imgname))) { mkdir(dirname($imgname), 0777, true); }
        			$overwrite = false;
//                    $overwrite_all;
        			$exists = file_exists($imgname);
        			if ($exists) {
        				if ($overwrite_all === 0) {
        					$choices = array('yes','all','no','no-all','y','n','nall');
        					$answer = $dialog->select(
        						$output,
        						'Following file already exists : '."\n".'> '. str_replace(ROOT, '', $imgname). "\n". 'Overwrite ? [yes]',
        						$choices,
        						0,
        						false,
        						'Answer "%s" is not correct'
        					);
        
        					$answer = $choices[$answer];
        					$selected =	$answer === 'y' ? 'yes' :
        								($answer === 'n' ? 'no' :
        								($answer === 'nall' ? 'no-all' : $answer));
        					if ($selected === 'yes') {
        						$overwrite = true;
        					} elseif ($selected === 'all') {
        						$overwrite = true;
        						$overwrite_all = 1;
        					} elseif ($selected === 'no') {
        						$overwrite = false;
        					} elseif ($selected === 'no-all') {
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
                    
                    $_x = $x*$img_size;
                    $_y = $y*$img_size;
                    if ($overwrite) {
                        $files_written++;
                        //Génération de l'offset à partir des X et Y demandés

                        //Commande ImageMagick
                        $cmd = 'convert'.
                                "\t".' "'.ROOT.'/web/'.$map->getImage().'"'.
                                "\t".($ratio < 1 ? ' -resize '.($ratio*100) .'%' : '').
                                "\t".' -background black'.//Le "surplus" sera noirs
                                "\t".' -extent '.$wmax.'x'.$hmax.'^'.//Redimensionne aux valeurs "width" et "height" maximales dépendant du zoom
                                "\t".' -crop '.$img_size.'x'.$img_size.'+'.$_x.'+'.$_y.//Découpe l'image selon la taille demandée dans les paramètres
                                "\t".' -extent '.$img_size.'x'.$img_size.'^'.//Et étend les éventuels pixels en trop ou en moins
                                "\t".' "'.$imgname.'"';

//                        $output->writeln('Executing command with values :');
//                        $output->writeln(' zoom='.$zoom);
//                        $output->writeln(' x='.$x);
//                        $output->writeln(' y='.$y);
//                        $output->writeln(' ratio='.$ratio);
//                        $output->writeln(" ".str_replace(ROOT.DS,'',$cmd));
            //            \CorahnRinTools\pr($cmd);exit;
//                        if (substr(php_uname(), 0, 7) == "Windows"){ 
//                            pclose(popen("start /B ". $cmd, "r"));  
//                        } 
//                        else { 
//                            shell_exec($cmd . " > /dev/null &");   
//                        }
                        shell_exec($cmd);
                    }

                    $p = ($current_file * 100 / $total_files);
                    $p = number_format($p, 2, '.', '');
                    $str = 0;
                    $str = '[';
                    $p2 = (int)($p/2);
                    for ($i = 0; $i <= 50; $i++) {
                        $str .= $p2 < $i ? ' ' : ($p2 === $i ? '>' : '=');
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
//                    print_r(array('sum'=>array_sum($times),'count'=>count($times),'median'=>$median));
                    $output->write(' '.$str." ".$p.'%  File '.$current_file.'/'.$total_files.'  x='.$x.' y='.$y.' z='.$zoom.'  Remaining : '.$time_remaining.' (estimation)'." \r");
                    
                }
            }
        }
		
		$output->writeln('End of function !');
        $output->writeln($files_written.' files have been written !');
        $output->writeln('Execution time : '.gmdate('H:i:s', microtime(true) - $global_time));
		$output->writeln('Thanks for using CorahnRinMaps, and see you soon !');
		
	}
}