<?php


namespace Tests\Admin;

use Tests\WebTestCase;

class DefaultEasyAdminTest extends WebTestCase
{

    /**
     * Test the homepage
     */
    public function testIndex()
    {
        $client = static::getClient('back.esteren.dev', array(), 'ROLE_ADMIN');

        $client->request('GET', '/fr/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode(), print_r($client->getResponse()->getContent(), true));
        $this->assertEquals('/fr/?action=list&entity=Pages', $client->getResponse()->headers->get('Location'));

        $crawler = $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals('EasyAdmin', $crawler->filter('meta[name="generator"]')->attr('content'));
    }

}
