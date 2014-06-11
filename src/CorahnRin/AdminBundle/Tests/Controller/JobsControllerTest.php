<?php

namespace CorahnRin\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JobsControllerTest extends WebTestCase
{
    public function testAdminlist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/jobs/');
    }

    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/jobs/add/');
    }

    public function testEdit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/jobs/edit/{id}');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin/generator/jobs/delete/{id}');
    }

}
