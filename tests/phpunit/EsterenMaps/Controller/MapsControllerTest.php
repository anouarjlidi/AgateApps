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
    public function testIndexAndViewLink()
    {
        $client = static::getClient('maps.esteren.dev');

        $this->setToken($client, 'map_allowed', array('ROLE_MAPS_VIEW'));

        $crawler = $client->request('GET', '/fr/');

        $article = $crawler->filter('.maps-list article');
        $this->assertGreaterThanOrEqual(1, $article->count(), print_r($client->getResponse()->getContent(), true));

        $link = $article->filter('a')->link();

        $crawler = $client->click($link);

        $this->assertEquals(1, $crawler->filter('#map_wrapper')->count(), print_r($client->getResponse()->getContent(), true));
    }

}
