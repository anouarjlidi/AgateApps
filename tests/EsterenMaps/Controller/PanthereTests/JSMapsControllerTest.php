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
use Panthere\ProcessManager\ChromeManager;
use Tests\WebTestCase as PiersTestCase;

class JSMapsControllerTest extends PanthereTestCase
{
    use PiersTestCase;

    protected function screenshot(Client $client, string $testMethod, string $suffix)
    {
        $normalizedMethod = preg_replace('^tests_', '', str_replace(['\\'], '_', $testMethod));

        $fileName = __DIR__.'/../../../../build/screenshots/'.$normalizedMethod.$suffix.'.png';

        $client->takeScreenshot($fileName);
    }

    public function testMapIndex()
    {
        static::startWebServer(null, '127.0.0.1', 9900);

        $chromeManager = new ChromeManager('chromedriver', []);
        $client = self::$panthereClient = new Client($chromeManager, self::$baseUri);

        $crawler = $client->request('GET', 'http://maps.esteren.docker:9900/fr/login');

        $form = $crawler->filter('#form_login')->form();
        $form->get('_username_or_email')->setValue('Pierstoval');
        $form->get('_password')->setValue('admin');

        $client->submit($form);

        $this->screenshot($client, __METHOD__, 'login_response');

        $crawler = $client->request('GET', 'http://maps.esteren.docker:9900/fr/map-tri-kazel');

        $this->screenshot($client, __METHOD__, 'map_view');

        static::assertSame(200, $client->getInternalResponse()->getStatus());
        static::assertCount(1, $crawler->filter('#map_wrapper'), 'Map link does not redirect to map view, or map view is broken');
    }
}
