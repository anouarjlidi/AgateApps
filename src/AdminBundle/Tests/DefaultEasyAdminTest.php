<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;

class DefaultEasyAdminTest extends WebTestCase
{
    use PiersTestCase;

    /**
     * Test backend homepage.
     */
    public function testIndex()
    {
        static::resetDatabase();

        $client = $this->getClient('back.esteren.dev', [], 'ROLE_ADMIN');

        $crawler = $client->request('GET', '/fr/');

        static::assertSame(302, $client->getResponse()->getStatusCode(), $crawler->filter('title')->html());
        static::assertSame('/fr/?action=list&entity=Pages', $client->getResponse()->headers->get('Location'));

        $crawler = $client->followRedirect();

        static::assertSame(200, $client->getResponse()->getStatusCode(), $crawler->filter('title')->html());
        static::assertSame('EasyAdmin', $crawler->filter('meta[name="generator"]')->attr('content'));
        static::assertGreaterThanOrEqual(1, $crawler->filter('#main.content .table-responsive tbody tr[data-id]')->count());
    }
}
