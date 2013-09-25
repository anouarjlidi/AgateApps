<?php

namespace CorahnRin\CharactersBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GeneratorControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/generate');
    }

    public function testStep()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/generate/{id}_{slug}');
    }

}
