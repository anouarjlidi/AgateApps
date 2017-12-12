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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;

class VermineControllerTest extends WebTestCase
{
    use PiersTestCase;

    /**
     * @dataProvider provideLocales
     */
    public function testVerminePortal($locale)
    {
        $client = $this->getClient('www.vermine2047.dev');

        $crawler = $client->request('GET', "/$locale/");

        // Ensures that portal homepage is managed in a controller and not in the CMS
        static::assertSame('vermine_portal_home', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame('Vermine 2047', trim($crawler->filter('title')->text()));
        static::assertSame($locale, trim($crawler->filter('html')->first()->attr('lang')));
    }

    public function provideLocales()
    {
        return [
            'fr' => ['fr'],
            'en' => ['en'],
        ];
    }
}
