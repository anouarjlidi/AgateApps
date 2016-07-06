<?php

namespace Tests\DependencyInjection;

use Tests\WebTestCase;

class AppContainerTest extends WebTestCase
{

    public function provideServiceIds()
    {
        return [
            'corahnrin_generator.pdf_manager'     => ['corahnrin_generator.pdf_manager'],
            'corahnrin_generator.steps.step_01'   => ['corahnrin_generator.steps.step_01'],
            'corahnrin_generator.steps.step_02'   => ['corahnrin_generator.steps.step_02'],
            'corahnrin_generator.steps.step_03'   => ['corahnrin_generator.steps.step_03'],
            'corahnrin_generator.steps.step_04'   => ['corahnrin_generator.steps.step_04'],
            'corahnrin_generator.steps.step_05'   => ['corahnrin_generator.steps.step_05'],
            'corahnrin_generator.steps.step_06'   => ['corahnrin_generator.steps.step_06'],
            'corahnrin_generator.steps.step_07'   => ['corahnrin_generator.steps.step_07'],
            'corahnrin_generator.steps.step_08'   => ['corahnrin_generator.steps.step_08'],
            'corahnrin_generator.steps.step_09'   => ['corahnrin_generator.steps.step_09'],
            'corahnrin_generator.steps.step_10'   => ['corahnrin_generator.steps.step_10'],
            'corahnrin_generator.steps.step_11'   => ['corahnrin_generator.steps.step_11'],
            'corahnrin_generator.steps.step_12'   => ['corahnrin_generator.steps.step_12'],
            'corahnrin_generator.steps.step_13'   => ['corahnrin_generator.steps.step_13'],
            'corahnrin_generator.steps.step_14'   => ['corahnrin_generator.steps.step_14'],
            'corahnrin_generator.steps.step_15'   => ['corahnrin_generator.steps.step_15'],
            'corahnrin_generator.steps.step_16'   => ['corahnrin_generator.steps.step_16'],
            'corahnrin_generator.steps.step_17'   => ['corahnrin_generator.steps.step_17'],
            'corahnrin_generator.steps.step_18'   => ['corahnrin_generator.steps.step_18'],
            'corahnrin_generator.steps.step_19'   => ['corahnrin_generator.steps.step_19'],
            'corahnrin_generator.steps.step_20'   => ['corahnrin_generator.steps.step_20'],

            'esterenmaps'                         => ['esterenmaps'],
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
            static::fail('Service '.$serviceId.' does not exist.');

            return;
        }

        $service = $container->get($serviceId);
        static::assertNotNull($service);
    }

}
