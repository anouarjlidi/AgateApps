<?php


namespace EsterenMaps\MapsBundle\Command;

use EsterenMaps\MapsBundle\Entity\Maps;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ChangeCoordinatesSystemCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('esterenmaps:map:change-coordinates')
            ->setDescription('Changes the coordinates system for a map.')
            ->setHelp('This allows you to switch from { latitude, longitude } coordinates system with Mercator Projection'
                      ."\n".'(which is limited in terms of minimum and maximum latitude and longitude) to a classic and'
                      ."\n".'infinite { x, y } canvas that will allow both negative and positive coordinates.'
                      ."\n\n".'<info>Be very careful</info> because it can change a lot of things, and can also change the map representation!')
            ->addArgument('system', InputArgument::REQUIRED, 'The system you want to use. Can be one of "latlng" or "xy".')
            ->addArgument('id', InputArgument::OPTIONAL, 'The ID of the map to manage..', null)
            ->addOption('--force', null, InputOption::VALUE_NONE, 'By default, this command executes as dry run. This option will update the whole database.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO
    }
}
