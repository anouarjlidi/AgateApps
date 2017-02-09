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

class LegalMentionsControllerTest extends WebTestCase
{
    /**
     * @param string $locale
     *
     * @dataProvider provideAllowedLocales
     */
    public function testLegalMentionsForAllowedLocales($locale)
    {
        parent::resetDatabase();

        $client = $this->getClient('portal.esteren.dev');

        $crawler = $client->request('GET', '/'.$locale.'/legal');

        static::assertSame('legal_mentions', $client->getRequest()->attributes->get('_route'));

        static::assertSame(200, $client->getResponse()->getStatusCode());

        static::assertStringStartsWith('Article 1', trim($crawler->filter('#content h3#article-1')->text()));
    }

    public function provideAllowedLocales()
    {
        return [
            ['fr'],
        ];
    }

    /**
     * @param string $locale
     *
     * @dataProvider provideNotAllowedLocales
     */
    public function testLegalMentionsWithNotAllowedLocales($locale)
    {
        parent::resetDatabase();

        $client = $this->getClient('portal.esteren.dev');

        $client->request('GET', '/'.$locale.'/legal');

        static::assertSame(404, $client->getResponse()->getStatusCode());
    }

    public function provideNotAllowedLocales()
    {
        return [
            ['en'],
            ['es'],
        ];
    }
}
