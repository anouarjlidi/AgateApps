<?php

namespace CorahnRin\PagesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MenusControllerTest extends WebTestCase
{
    public function testBase()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/base');
    }

    public function testAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin');
    }

}
