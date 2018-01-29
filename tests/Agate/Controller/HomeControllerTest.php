<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Agate\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;

class HomeControllerTest extends WebTestCase
{
    use PiersTestCase;

    public function testRootRedirectsToIndex()
    {
        $client = $this->getClient('www.studio-agate.dev');

        $client->request('GET', '/');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://www.studio-agate.dev/fr/', $res->headers->get('Location'));
    }

    public function testIndexWithoutSlashRedirectsWithASlash()
    {
        $client = $this->getClient('www.studio-agate.dev');

        $client->request('GET', '/fr');
        $res = $client->getResponse();

        static::assertSame(301, $res->getStatusCode());
        static::assertSame('http://www.studio-agate.dev/fr/', $res->headers->get('Location'));
    }

    /**
     * @dataProvider provideHomepageData
     */
    public function testAgateHomepage(string $locale, string $expectedTitle)
    {
        static::resetDatabase();

        $client = $this->getClient('www.studio-agate.dev');

        $crawler = $client->request('GET', "/$locale/");

        static::assertSame('agate_portal_home', $client->getRequest()->attributes->get('_route'));
        static::assertSame(200, $client->getResponse()->getStatusCode(), trim($crawler->filter('title')->text()));
        static::assertSame($expectedTitle, trim($crawler->filter('#content h1')->text()));
    }

    public function provideHomepageData()
    {
        yield 'fr' => ['fr', 'Bienvenue sur le nouveau portail du Studio Agate'];
        yield 'en' => ['en', 'Welcome to the new Studio Agate portal'];
    }

    public function testFrenchTeamPage()
    {
        $client = $this->getClient('www.studio-agate.dev');

        $crawler = $client->request('GET', '/fr/team');

        static::assertSame('agate_team', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame('L\'Équipe du studio Agate', trim($crawler->filter('#content h1')->text()));
    }

    public function testEnglishTeamPage()
    {
        $client = $this->getClient('www.studio-agate.dev');

        $crawler = $client->request('GET', '/en/team');

        static::assertSame('agate_team', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame('The Studio Agate team', trim($crawler->filter('#content h1')->text()));
    }
}