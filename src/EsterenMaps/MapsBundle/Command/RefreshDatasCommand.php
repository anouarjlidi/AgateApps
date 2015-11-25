<?php
namespace EsterenMaps\MapsBundle\Command;

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshDatasCommand extends ContainerAwareCommand {

	protected function configure() {
		$this
            ->setName('esterenmaps:map:refresh')
            ->setDescription('Refresh all dynamic datas (routes distances, etc.)')
            ->setHelp('This command is here to update all datas that may be dynamic.'."\n"
              .'For example, the start and end marker of each route may change its coordinates,'."\n"
              .'and the distance depends on the coordinates, so both datas are updated with this command.'."\n\n"
              .'This command runs on every data for every map in the database.'
            )
        ;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
    {

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getManager();
        $maps = $em->getRepository('EsterenMapsBundle:Maps')->findAll();

        $numberTotal = 0;
        $numberModified = 0;

        foreach ($maps as $map) {

            foreach ($map->getRoutes() as $route) {
                $route->refresh();
                $em->persist($route);
                $numberTotal++;
            }
        }

        $uow = $em->getUnitOfWork();
        $uow->computeChangeSets();

        foreach ($maps as $map) {
            foreach ($map->getRoutes() as $route) {
                $changesets = $uow->getEntityChangeSet($route);

                if (isset($changesets['distance'])) {
                    $changesets['distance'] = array_map(function($e) {
                        // This trick truncates the number
                        // Else, a number like 219.664402090055 would have been treated as 219.664402090060
                        $shift = pow(10, 10);
                        $e = ((floor($e * $shift)) / $shift);
                        return number_format($e, 11, '.', '');
                    }, $changesets['distance']);
                    if ($changesets['distance'][0] === $changesets['distance'][1]) {
                        unset($changesets['distance']);
                    }
                }

                if (!count($changesets)) {
                    continue;
                }

                $numberModified++;
            }
        }

        if ($numberModified === 0) {
            $output->writeln('Nothing to be updated.');
            return 1;
        }

        $output->writeln('Elements updated: <info>'.$numberModified.' / '.$numberTotal.'</info>');

        try {
            $em->flush();
        } catch (\Exception $e) {
            throw $e;
        }

        $output->writeln('Finished!');

	}
}
