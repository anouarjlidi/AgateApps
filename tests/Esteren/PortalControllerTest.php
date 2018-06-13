<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Esteren;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;

class PortalControllerTest extends WebTestCase
{
    use PiersTestCase;

    public function testRootRedirectsToIndex()
    {
        $client = $this->getClient('portal.esteren.docker');

        $client->request('GET', '/');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://portal.esteren.docker/fr/', $res->headers->get('Location'));
    }

    public function testIndexWithoutSlashRedirectsWithASlash()
    {
        $client = $this->getClient('portal.esteren.docker');

        $client->request('GET', '/fr');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://portal.esteren.docker/fr/', $res->headers->get('Location'));
    }

    public function testIndexWithFrenchHomepage()
    {
        static::resetDatabase();

        $client = $this->getClient('portal.esteren.docker');

        $crawler = $client->request('GET', '/fr/');


        static::assertSame('esteren_portal_home', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame('Bienvenue sur le nouveau portail des Ombres d\'Esteren', trim($crawler->filter('#content h1')->text()));
    }

    public function testIndexWithEnglishHomepage()
    {
        static::resetDatabase();

        $client = $this->getClient('portal.esteren.docker');

        $crawler = $client->request('GET', '/en/');


        static::assertSame('esteren_portal_home', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame('Welcome to the new Shadows of Esteren\'s portal!', trim($crawler->filter('#content h1')->text()));
    }
}
