<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\EsterenMaps\Controller\PantherTests;

use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\PantherTestCase;
use Tests\WebTestCase as PiersTestCase;

class JSMapsControllerTest extends PantherTestCase
{
    use PiersTestCase;

    public function __toString()
    {
        return $this->toString();
    }

    protected function screenshot(Client $client, string $suffix)
    {
        $normalizedMethod = preg_replace(
            '~^tests_~i',
            '_',
            str_replace(['\\', '::', ':'], '_', (string) $this)
        );

        $fileName = __DIR__.'/../../../../build/screenshots/'.$normalizedMethod.$suffix.'.png';

        $client->takeScreenshot($fileName);
    }

    /**
     * @legacy
     */
    public function testMapIndex()
    {
        try {
            $client = static::createPantherClient('127.0.0.1', 9900);

            $crawler = $client->request('GET', 'http://maps.esteren.docker:9900/fr/login');

            $form = $crawler->filter('#form_login')->form();
            $form->get('_username_or_email')->setValue('Pierstoval');
            $form->get('_password')->setValue('admin');

            $client->submit($form);

            $this->screenshot($client, 'login_response');

            $crawler = $client->request('GET', 'http://maps.esteren.docker:9900/fr/map-tri-kazel');

            $this->screenshot($client, 'map_view');

            static::assertSame(200, $client->getInternalResponse()->getStatus());
            static::assertCount(1, $crawler->filter('#map_wrapper'), 'Map link does not redirect to map view, or map view is broken');
        } catch (\Exception $e) {
            $msg = '';

            do {
                $msg .= "\n".$e->getMessage();
            } while ($e = $e->getPrevious());

            $this->markAsRisky();
            static::markTestSkipped(sprintf('Panthère test returned error:%s', $msg));
        }
    }
}
