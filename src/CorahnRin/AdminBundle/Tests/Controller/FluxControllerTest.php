<?php

namespace CorahnRin\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FluxControllerTest extends WebTestCase
{
    public function testAdminlist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/flux/');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/flux/add/');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/flux/edit/{id}');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/flux/delete/{id}');
    }

}
