<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Dragons;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;

class PortalControllerTest extends WebTestCase
{
    use PiersTestCase;

    public function testRootRedirectsToIndex()
    {
        $client = $this->getClient('www.dragons-rpg.dev');

        $client->request('GET', '/');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://www.dragons-rpg.dev/fr/', $res->headers->get('Location'));
    }

    public function testIndexWithoutSlashRedirectsWithASlash()
    {
        $client = $this->getClient('www.dragons-rpg.dev');

        $client->request('GET', '/fr');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://www.dragons-rpg.dev/fr/', $res->headers->get('Location'));
    }

    public function testIndexWithFrenchHomepage()
    {
        static::resetDatabase();

        $client = $this->getClient('www.dragons-rpg.dev');

        $crawler = $client->request('GET', '/fr/');


        static::assertSame('dragons_home', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame('Bienvenue sur le nouveau portail du jeu de rôle Dragons', trim($crawler->filter('#content h1')->text()));
    }

    public function testIndexWithEnglishHomepage()
    {
        static::resetDatabase();

        $client = $this->getClient('www.dragons-rpg.dev');

        $crawler = $client->request('GET', '/en/');


        static::assertSame('dragons_home', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame('Welcome to Dragons RPG portal', trim($crawler->filter('#content h1')->text()));
    }
}
