<?php

namespace CorahnRin\CharactersBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ViewerControllerTest extends WebTestCase
{
    public function testView()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/{id}-{name}');
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }

    public function testPdf()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/pdf/{id}-{name}.pdf');
    }

    public function testZip()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/zip/{id}-{name}.zip');
    }

    public function testJpg()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/jpg/{id}-{name}.zip');
    }

}
