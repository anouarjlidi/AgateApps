<?php

namespace EsterenMaps\MapsBundle\Tests\Services;

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Services\MapsRegistry;
use Tests\WebTestCase;

class DirectionsManagerTest extends WebTestCase
{
    /**
     * @dataProvider provideWorkingDirections
     *
     * @param array   $expectedData
     * @param integer $map
     * @param string  $from
     * @param string  $to
     * @param null    $transport
     */
    public function testWorkingDirections(array $expectedData, $map, $from, $to, $transport = null)
    {
        static::bootKernel();

        $container = static::$kernel->getContainer();

        /** @var EntityManager $em */
        $em = $container->get('doctrine.orm.default_entity_manager');

        /** @var MapsRegistry $maps */
        $maps = $container->get('esterenmaps');

        $directions = $maps->getDirectionsManager();

        /** @var Maps $map */
        $map  = $em->getRepository('EsterenMapsBundle:Maps')->findOneBy(['nameSlug' => $map]);

        /** @var Markers $from */
        $from = $em->getRepository('EsterenMapsBundle:Markers')->findOneBy(['name' => $from]);

        /** @var Markers $to */
        $to   = $em->getRepository('EsterenMapsBundle:Markers')->findOneBy(['name' => $to]);

        if ($transport) {
            $transport = $em->getRepository('EsterenMapsBundle:TransportTypes')->findOneBy(['slug' => $transport]);
        }

        $dirs = $directions->getDirections($map, $from, $to, 7, $transport);

        foreach ($expectedData as $key => $expectedValue) {
            static::assertArrayHasKey($key, $dirs);
            if (array_key_exists($key, $dirs)) {
                static::assertSame($expectedValue, $dirs[$key], 'Json response key "'.$key.'" has invalid value.');
            }
        }
    }

    /**
     * Syntax:
     * > Expected output values (will check only these ones, if there are others, we don't check it).
     * > Map slug
     * > FROM Marker name
     * > TO marker name
     * > WITH Transport slug (can be null)
     *
     * @return array[]
     */
    public function provideWorkingDirections()
    {
        return [
            // Test from bottom left to top right with no transport (similar to "default")
            [
                [
                    'found'           => true,
                    'from_cache'      => false,
                    'number_of_steps' => 16,
                ],
                'tri-kazel',
                'Pointe de Hòb',
                'Col de Gaos-Bodhar',
                null,
            ],
            // Test from bottom left to top right with "default" transport
            [
                [
                    'found'           => true,
                    'from_cache'      => false,
                    'number_of_steps' => 16,
                ],
                'tri-kazel',
                'Pointe de Hòb',
                'Col de Gaos-Bodhar',
                'transport-par-defaut',
            ],
            // Test from bottom left to top right with ground transport
            [
                [
                    'found'           => true,
                    'from_cache'      => false,
                    'number_of_steps' => 18,
                ],
                'tri-kazel',
                'Pointe de Hòb',
                'Col de Gaos-Bodhar',
                'chariot',
            ],
            // Test small ship transport with only routes in the sea
            [
                [
                    'found'           => true,
                    'from_cache'      => false,
                    'number_of_steps' => 2,
                ],
                'tri-kazel',
                'Tuaille',
                'Seòl',
                'coracle',
            ],
        ];
    }
}
