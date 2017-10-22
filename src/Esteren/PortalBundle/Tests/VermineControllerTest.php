<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esteren\PortalBundle\Tests;

use Tests\WebTestCase;

class VermineControllerTest extends WebTestCase
{
    public function testVermineLandingPage()
    {
        $client = $this->getClient('www.vermine2047.dev');

        $crawler = $client->request('GET', '/fr/');

        static::assertSame('vermine_portal_home', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertCount(1, $crawler->filter('#vermine_container'));
    }
}
