<?php

namespace EsterenMaps\MapsBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiControllerTest extends WebTestCase
{
    public function testInit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/maps/ajax/init/{id}');
    }

}
