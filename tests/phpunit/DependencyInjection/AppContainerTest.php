<?php

namespace Tests\DependencyInjection;

use Tests\WebTestCase;

class AppContainerTest extends WebTestCase
{

    public function provideServiceIds()
    {
        return [
            'corahn_rin_generator.sheets_manager' => ['corahn_rin_generator.sheets_manager'],
            'corahn_rin_generator.steps_loader'   => ['corahn_rin_generator.steps_loader'],
            'esteren_maps'                        => ['esteren_maps'],
            'esterenmaps.tiles_manager'           => ['esterenmaps.tiles_manager'],
            'esterenmaps.map_image_manager'       => ['esterenmaps.map_image_manager'],
            'esterenmaps.directions_manager'      => ['esterenmaps.directions_manager'],
            'esterenmaps.coordinates_manager'     => ['esterenmaps.coordinates_manager'],
            'esterenmaps.subscriber.cache_clear'  => ['esterenmaps.subscriber.cache_clear'],
            'pierstoval.api.listener'             => ['pierstoval.api.listener'],
            'pierstoval.api.origin_checker'       => ['pierstoval.api.origin_checker'],
            'pierstoval_tools.twig.json'          => ['pierstoval_tools.twig.json'],
        ];
    }

    /**
     * @dataProvider provideServiceIds
     *
     * @param string $serviceId
     */
    public function testContainer($serviceId)
    {
        $container = $this->getClient()->getContainer();

        // We "fail" manually to avoid phpunit to say there's an error.
        if (!$container->has($serviceId)) {
            $this->fail('Service '.$serviceId.' does not exist.');

            return;
        }

        $service = $container->get($serviceId);
        $this->assertNotNull($service);
    }

}
