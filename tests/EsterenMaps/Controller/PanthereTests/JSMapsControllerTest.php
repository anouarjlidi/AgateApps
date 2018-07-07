<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\EsterenMaps\Controller\PanthereTests;

use Panthere\Client;
use Panthere\PanthereTestCase;
use Tests\WebTestCase as PiersTestCase;

class JSMapsControllerTest extends PanthereTestCase
{
    use PiersTestCase;

    public function testMapIndex()
    {
        static::startWebServer(null, '127.0.0.1', 9900);
        $client = self::$panthereClient = Client::createChromeClient('chromedriver', null, ['binary' => 'chromium'], self::$baseUri);

        $client->request('GET', 'http://maps.esteren.docker:9900/fr/login');

        $crawler = $client->request('GET', 'http://maps.esteren.docker:9900/fr/map-tri-kazel');

        static::assertSame(200, $client->getInternalResponse()->getStatus());
        static::assertCount(1, $crawler->filter('#map_wrapper'), 'Map link does not redirect to map view, or map view is broken');
    }
}
