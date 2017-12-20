<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;

class LegalMentionsControllerTest extends WebTestCase
{
    use PiersTestCase;

    /**
     * @param string $locale
     *
     * @dataProvider provideAllowedLocales
     */
    public function testLegalMentionsForAllowedLocales($locale)
    {
        $client = $this->getClient('www.studio-agate.dev');

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
