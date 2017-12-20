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

class VermineControllerTest extends WebTestCase
{
    use PiersTestCase;

    public function testRootRedirectsToIndex()
    {
        $client = $this->getClient('www.vermine2047.dev');

        $client->request('GET', '/');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://www.vermine2047.dev/fr/', $res->headers->get('Location'));
    }

    public function testIndexWithoutSlashRedirectsWithASlash()
    {
        $client = $this->getClient('www.vermine2047.dev');

        $client->request('GET', '/fr');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://www.vermine2047.dev/fr/', $res->headers->get('Location'));
    }

    public function testVermineLandingPage()
    {
        $client = $this->getClient('www.vermine2047.dev');

        $crawler = $client->request('GET', '/fr/');

        static::assertSame('vermine_portal_home', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertCount(1, $crawler->filter('#vermine_container'));
    }
}
