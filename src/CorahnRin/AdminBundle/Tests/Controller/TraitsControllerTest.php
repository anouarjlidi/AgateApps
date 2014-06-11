<?php

namespace CorahnRin\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TraitsControllerTest extends WebTestCase
{
    public function testAdminlist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/traits/');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/traits/add/');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/traits/edit/{id}');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/traits/delete/{id}');
    }

}
