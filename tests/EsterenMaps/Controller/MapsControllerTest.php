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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;

class MapsControllerTest extends WebTestCase
{
    use PiersTestCase;

    public function testRootRedirectsToIndex()
    {
        $client = $this->getClient('maps.esteren.dev');

        $client->request('GET', '/');
        $res = $client->getResponse();

        static::assertSame(302, $res->getStatusCode());
        static::assertSame('/fr/login', $res->headers->get('Location'));
    }

    public function testIndexWithoutSlashRedirectsWithASlash()
    {
        $client = $this->getClient('maps.esteren.dev');

        $client->request('GET', '/fr');
        $res = $client->getResponse();

        static::assertSame(302, $res->getStatusCode());
        static::assertSame('/fr/login', $res->headers->get('Location'));
    }

    public function testIndexAndViewLink()
    {
        $client = $this->getClient('maps.esteren.dev');

        static::setToken($client, 'map_allowed', ['ROLE_MAPS_VIEW']);

        $crawler = $client->request('GET', '/fr/');

        static::assertSame(200, $client->getResponse()->getStatusCode());

        $article = $crawler->filter('.maps-list article');
        static::assertGreaterThanOrEqual(1, $article->count(), $crawler->filter('title')->text());

        $link = $article->filter('a')->link();

        $crawler = $client->click($link);

        static::assertCount(1, $crawler->filter('#map_wrapper'), 'Map link does not redirect to map view, or map view is broken');
    }
}
