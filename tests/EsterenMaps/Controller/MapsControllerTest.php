<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\EsterenMaps\Controller;

use Agate\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Link;
use Tests\WebTestCase as PiersTestCase;

class MapsControllerTest extends WebTestCase
{
    use PiersTestCase;

    public function testRootRedirectsToIndex()
    {
        $client = $this->getClient('maps.esteren.dev');

        $client->request('GET', '/');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://maps.esteren.dev/fr/', $res->headers->get('Location'));
    }

    public function testIndexWithoutSlashRedirectsWithASlash()
    {
        $client = $this->getClient('maps.esteren.dev');

        $client->request('GET', '/fr');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://maps.esteren.dev/fr/', $res->headers->get('Location'));
    }

    public function testIndex()
    {
        $client = $this->getClient('maps.esteren.dev');

        static::setToken($client, 'map_allowed', ['ROLE_MAPS_VIEW']);

        $crawler = $client->request('GET', '/fr/');

        static::assertSame(200, $client->getResponse()->getStatusCode());

        $article = $crawler->filter('.maps-list article');
        static::assertGreaterThanOrEqual(1, $article->count(), $crawler->filter('title')->text());

        $link = $article->filter('a')->link();

        static::assertInstanceOf(Link::class, $link);
        static::assertSame('Voir la carte', trim($link->getNode()->textContent));
        static::assertSame('http://maps.esteren.dev/fr/map-tri-kazel', trim($link->getUri()));
    }

    public function testViewWhileNotLoggedIn()
    {
        $client = $this->getClient('maps.esteren.dev');

        $client->request('GET', '/fr/map-tri-kazel');
        $res = $client->getResponse();

        static::assertSame(302, $res->getStatusCode());
        static::assertSame('/fr/login', $res->headers->get('Location'));
    }

    public function testViewWhenAuthenticatedWithoutPermission()
    {
        $client = $this->getClient('maps.esteren.dev');

        static::setToken($client);

        $client->request('GET', '/fr/map-tri-kazel');
        $res = $client->getResponse();

        static::assertSame(403, $res->getStatusCode());
    }

    public function testViewWhileConnected()
    {
        $client = $this->getClient('maps.esteren.dev');

        $user = $client->getContainer()->get(UserRepository::class)->findByUsernameOrEmail('pierstoval');

        static::assertNotNull($user);
        static::setToken($client, $user);

        $crawler = $client->request('GET', '/fr/map-tri-kazel');
        $res = $client->getResponse();

        static::assertSame(200, $res->getStatusCode());
        static::assertCount(1, $crawler->filter('#map_wrapper'), 'Map link does not redirect to map view, or map view is broken');
    }
}
