<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Tests\Controller\Api;

use Tests\WebTestCase;

class MapsControllerTest extends WebTestCase
{
    public function testPage()
    {
        $client = $this->getClient('api.esteren.dev');

        static::setToken($client, 'map_allowed', ['ROLE_MAPS_VIEW']);

        $client->request('GET', '/fr/maps/1');

        $response = $client->getResponse();

        $jsonContent = $response->getContent();

        $data = json_decode($jsonContent, true);

        if (false === $data && json_last_error()) {
            static::fail(json_last_error_msg());
        }

        static::assertSame(1, $data['id'] ?? null);
        static::assertSame('tri-kazel', $data['name_slug'] ?? null);
    }
}
