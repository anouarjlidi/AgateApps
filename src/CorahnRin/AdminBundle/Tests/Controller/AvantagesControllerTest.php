<?php

namespace CorahnRin\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AvantagesControllerTest extends WebTestCase
{
    public function testAdminlist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/avantages/');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/avantages/add/');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/avantages/edit/{id}');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/avantages/delete/{id}');
    }

}
