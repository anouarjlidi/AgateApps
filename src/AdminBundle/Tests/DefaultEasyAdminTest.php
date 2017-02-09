<?php

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
