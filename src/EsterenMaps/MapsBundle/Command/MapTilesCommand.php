<?php
namespace EsterenMaps\MapsBundle\Command;

use EsterenMaps\MapsBundle\Entity\Maps;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use EsterenMaps\MapsBundle\Services\MapsTilesManager;

class MapTilesCommand extends ContainerAwareCommand {

	protected function configure() {

		//public function addArgument($name, $mode = null, $description = '', $default = null)
		$this
		->setName('esterenmaps:generate:map-tiles')
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

	protected function execute(InputInterface $input, OutputInterface $output) {

        $id = $input->hasArgument('id') ? $input->getArgument('id') : null;

        /** @var DialogHelper $dialog */
		$dialog = $this->getHelperSet()->get('dialog');

        /** @var BaseEntityRepository $repo */
        $repo = $this->getContainer()->get('doctrine')->getManager()->getRepository('EsterenMapsBundle:Maps');

        $list = null;

		$output->writeln('Be careful : as maps may be huge, this application can use a lot of memory and take very long to execute.');
		$output->writeln('');

        /** @var Maps $map */
        $map = null;
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
                    'Select a map to generate:',
                    $maps_list,
                    false,
                    false,
                    'No id "%s" in maps list.'
                );
            }
        } while (!$map);

		$output->writeln('Generating map tiles for "'.$map->getName().'"');

        $tilesManager = $this->getContainer()->get('esterenmaps.tiles_manager');

        if (!file_exists($map->getImage())) {
            $img = $this->getContainer()->getParameter('kernel.root_dir').'/../web/'.$map->getImage();
            $map->setImage($img);
        }
        if (!file_exists($map->getImage())) {
            throw new \RuntimeException('Map image cannot be found.');
        }

        $tilesManager->setMap($map);

        $i = 0;

        try {
            for ($i = 0; $i <= $map->getMaxZoom(); $i++) {
                $output->writeln('Processing extraction for zoom value '.$i);
                $tilesManager->generateTiles($i, true);
            }
        } catch (\Exception $e) {
            $output->writeln('<error>Error while processing extraction for zoom value "'.$i.'", got following message :</error>');
            $output->writeln('<error>'.$e->getMessage().'</error>');
        }

        return 0;
	}
}
