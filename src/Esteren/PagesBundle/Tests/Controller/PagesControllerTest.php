<?php

namespace Esteren\PagesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PagesControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}_-_{slug}');
    }

    public function testModify()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/modify/{id}');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/pages/delete');
    }

    public function testCreate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/pages/create');
    }

}
