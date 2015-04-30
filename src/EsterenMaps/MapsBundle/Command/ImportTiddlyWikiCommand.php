<?php
namespace EsterenMaps\MapsBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportTiddlyWikiCommand extends ContainerAwareCommand
{

    protected function configure()
    {

        //public function addArgument($name, $mode = null, $description = '', $default = null)
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

        foreach ($datas as $object) {
            //
        }

    }
}
