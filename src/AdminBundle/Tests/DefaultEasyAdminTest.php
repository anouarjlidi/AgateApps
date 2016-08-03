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
        $client = $this->getClient('back.esteren.dev', array(), 'ROLE_ADMIN');

        $client->request('GET', '/fr/');

        static::assertEquals(302, $client->getResponse()->getStatusCode(), print_r($client->getResponse()->getContent(), true));
        static::assertEquals('/fr/?action=list&entity=Pages', $client->getResponse()->headers->get('Location'));

        $crawler = $client->followRedirect();

        static::assertEquals(200, $client->getResponse()->getStatusCode(), $crawler->filter('title')->html());
        static::assertEquals('EasyAdmin', $crawler->filter('meta[name="generator"]')->attr('content'));
        static::assertGreaterThanOrEqual(1, $crawler->filter('#main.content .table-responsive tbody tr[data-id]')->count());
    }

}
