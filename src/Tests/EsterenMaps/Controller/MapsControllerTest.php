<?php

namespace Tests\EsterenMaps\Controller;

use Tests\WebTestCase;

/**
 * @see EsterenMaps\MapsBundle\Controller\MapsController
 */
class MapsControllerTest extends WebTestCase
{

    /**
     * @see MapsController::indexAction
     */
    public function testIndex()
    {
        $client = static::getClient('maps.esteren.dev');

        $crawler = $client->request('GET', '/fr/');

        $this->assertGreaterThanOrEqual(1, $crawler->filter('.maps-list article')->count());
    }

}
