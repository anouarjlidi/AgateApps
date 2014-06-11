<?php

namespace CorahnRin\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DisordersControllerTest extends WebTestCase
{
    public function testAdminlist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/disorders/');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/disorders/add/');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/disorders/edit/{id}');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/disorders/delete/{id}');
    }

}
