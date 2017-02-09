<?php

namespace EsterenMaps\MapsBundle\Tests\Controller;

use Tests\WebTestCase;

/**
 * @see \EsterenMaps\MapsBundle\Controller\MapsController
 */
class MapsControllerTest extends WebTestCase
{
    /**
     * @see MapsController::indexAction
     */
    public function testIndexAndViewLink()
    {
        $client = $this->getClient('maps.esteren.dev');

        static::setToken($client, 'map_allowed', array('ROLE_MAPS_VIEW'));

        $crawler = $client->request('GET', '/fr/');

        $article = $crawler->filter('.maps-list article');
        static::assertGreaterThanOrEqual(1, $article->count(), print_r($client->getResponse()->getContent(), true));

        $link = $article->filter('a')->link();

        $crawler = $client->click($link);

        static::assertSame(1, $crawler->filter('#map_wrapper')->count(), print_r($client->getResponse()->getContent(), true));
    }
}
