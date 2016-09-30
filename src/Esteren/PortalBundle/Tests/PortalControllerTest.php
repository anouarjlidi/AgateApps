<?php

namespace Esteren\PortalBundle\Tests;

use Doctrine\ORM\EntityManager;
use Esteren\PortalBundle\Entity\Page;
use Tests\WebTestCase;

class PortalControllerTest extends WebTestCase
{
    public function testIndexWithHomepage()
    {
        parent::resetDatabase();

        $client = $this->getClient('portal.esteren.dev');

        $crawler = $client->request('GET', '/fr/');
        static::assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
        static::assertEquals('Homepage', trim($crawler->filter('#content h1')->html()));
        static::assertContains('This this a default home page.', trim($crawler->filter('#content')->html()));
    }

    /**
     * @see GeneratorController::indexAction
     */
    public function testIndexWithOnePage()
    {
        parent::resetDatabase();

        $client = $this->getClient('portal.esteren.dev');

        $crawler = $client->request('GET', '/fr/page-test');
        static::assertEquals(200, $client->getResponse()->getStatusCode());

        static::assertEquals('Static page', trim($crawler->filter('#content h1')->html()));
        static::assertContains('This this a default static page.', trim($crawler->filter('#content')->html()));
    }

}
