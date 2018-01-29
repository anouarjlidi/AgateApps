<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Esteren;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;

class FeondBeerControllerTest extends WebTestCase
{
    use PiersTestCase;

    public function testFeondBeerLandingPage()
    {
        $client = $this->getClient('portal.esteren.dev');

        $crawler = $client->request('GET', '/fr/feond-beer');

        static::assertSame('esteren_portal_feond_beer', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertStringStartsWith('La bière du Féond', trim($crawler->filter('title')->text()));
    }
}