<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\AgateController;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;

class CorahnRinHomeController extends WebTestCase
{
    use PiersTestCase;

    /**
     * @dataProvider provideLocales
     */
    public function testVerminePortal(string $locale, string $expectedTitle)
    {
        $client = $this->getClient('corahnrin.esteren.dev');

        $crawler = $client->request('GET', "/$locale/");

        // Ensures that portal homepage is managed in a controller and not in the CMS
        static::assertSame('corahn_rin_home', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertSame($expectedTitle, trim($crawler->filter('title')->text()));
        static::assertSame($locale, trim($crawler->filter('html')->first()->attr('lang')));
    }

    public function provideLocales()
    {
        return [
            'fr' => ['fr', 'Corahn-Rin, le générateur de personnage pour Les Ombres d\'Esteren'],
            'en' => ['en', 'Corahn-Rin, the character manager for Shadows of Esteren'],
        ];
    }
}
