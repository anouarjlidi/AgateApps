<?php

namespace Esteren\PortalBundle\Tests;

use Tests\WebTestCase;

class PortalControllerTest extends WebTestCase
{
    public function testIndexWithHomepage()
    {
        parent::resetDatabase();

        $client = $this->getClient('portal.esteren.dev');

        $crawler = $client->request('GET', '/fr/');

        // Ensures that portal homepage is managed in a controller and not in the CMS
        static::assertEquals('portal_home', $client->getRequest()->attributes->get('_route'));

        static::assertEquals(200, $client->getResponse()->getStatusCode());

        // Check <h1> content only, this will be our "regression point" for homepage (now that it's static and no more in the CMS)
        static::assertEquals('Bienvenue sur le nouveau portail des Ombres d\'Esteren', trim($crawler->filter('#content h1')->text()));
    }
}
