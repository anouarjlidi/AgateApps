<?php

namespace Pierstoval\Bundle\ToolsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AssetsControllerTest extends WebTestCase
{
    public function testJs()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/js');
    }

    public function testJstranslations()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/js/{file}.js');
    }

}
