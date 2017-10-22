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

use Tests\WebTestCase;

class DefaultEasyAdminTest extends WebTestCase
{
    /**
     * Test backend homepage.
     */
    public function testIndex()
    {
        parent::resetDatabase();

        $client = $this->getClient('back.esteren.dev', [], 'ROLE_ADMIN');

        $client->request('GET', '/fr/');

        static::assertSame(302, $client->getResponse()->getStatusCode(), print_r($client->getResponse()->getContent(), true));
        static::assertSame('/fr/?action=list&entity=Pages', $client->getResponse()->headers->get('Location'));

        $crawler = $client->followRedirect();

        static::assertSame(200, $client->getResponse()->getStatusCode(), $crawler->filter('title')->html());
        static::assertSame('EasyAdmin', $crawler->filter('meta[name="generator"]')->attr('content'));
        static::assertGreaterThanOrEqual(1, $crawler->filter('#main.content .table-responsive tbody tr[data-id]')->count());
    }
}
