<?php

namespace EsterenMaps\MapsBundle\Command;

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ChangeCoordinatesSystemCommand.
 * 
 * @todo Remove this class.
 * @deprecated This class should NOT be used.
 */
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
            ->addArgument('id', InputArgument::OPTIONAL, 'The ID of the map to manage.', null)
            ->addOption('--force', null, InputOption::VALUE_NONE, 'By default, this command executes as dry run. This option will update the whole database.')
        ;
    }

    /**
     * WIP.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        /** @var DialogHelper $dialog */
        $dialog = $this->getHelperSet()->get('dialog');

        /** @var BaseEntityRepository $mapsRepo */
        $mapsRepo = $em->getRepository('EsterenMapsBundle:Maps');

        /* @var Maps $map */
        if ($input->getArgument('id')) {
            $map = $mapsRepo->find($input->getArgument('id'));
        } else {
            $maps = $mapsRepo->findAllRoot('id');

            if (!count($maps)) {
                $output->writeln('<comment>There is no map in the database.</comment>');

                return 1;
            }

            do {
                $id = $dialog->select(
                    $output,
                    'Select a map:',
                    $maps,
                    false,
                    false,
                    'Invalid id: "%s"'
                );
                $map = isset($maps[$id]) ? $maps[$id] : null;
            } while (!$map);
        }

        $output->writeln('Taking care of map <info>'.$map.'</info>');

        $marker = $map->getMarkers()[0];

        $xy = $this->transformLatLngToXY($map, (float) $marker->getLatitude(), (float) $marker->getLongitude());
    }

    /**
     * Transforms a latlng point to x,y.
     *
     * @param Maps  $map
     * @param float $lat
     * @param float $lng
     *
     * @return array
     */
    private function transformLatLngToXY(Maps $map, $lat, $lng)
    {
        $manager = $this->getContainer()->get('esteren_maps')->getTilesManager();

        $manager->setMap($map);

        $identification = $manager->identifyImage(1);

        $width = $identification->getGlobalWidth();
        $height = $identification->getGlobalHeight();

        return [
            'x' => ($lng + 180) * ($width / 360),
            'y' => ((-1 * $lat) + 90) * ($height / 180),
        ];
    }
}
