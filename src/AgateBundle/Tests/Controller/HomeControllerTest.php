<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AgateBundle\Tests\Controller;

use Tests\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndexWithFrenchHomepage()
    {
        $client = $this->getClient('www.studio-agate.dev');

        $crawler = $client->request('GET', '/fr/');

        // Ensures that portal homepage is managed in a controller and not in the CMS
        static::assertSame('agate_portal_home', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        // Check <h1> content only, this will be our "regression point" for homepage (now that it's static and no more in the CMS)
        static::assertSame('Bienvenue sur le nouveau portail du Studio Agate', trim($crawler->filter('#content h1')->text()));
    }

    public function testIndexWithEnglishHomepage()
    {
        $client = $this->getClient('www.studio-agate.dev');

        $client->request('GET', '/en/');

        // Ensures that portal homepage is managed in a controller and not in the CMS
        static::assertSame(404, $client->getResponse()->getStatusCode());
    }
}
