<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Tests\Step;

class Step12MentalDisorderTest extends AbstractStepTest
{
    public function testWaysDependency()
    {
        $client = $this->getClient();

        $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate'));
    }

    public function testValidMentalDisorder()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 5,
                2 => 4,
                3 => 3,
                4 => 2,
                5 => 1,
            ],
        ], [
            'gen-div-choice' => 1,
        ]);

        static::assertSame(302, $result->getResponse()->getStatusCode());
        static::assertTrue($result->getResponse()->isRedirect('/fr/character/generate/13_primary_domains'));
        static::assertSame(1, $result->getSession()->get('character')[$this->getStepName()]);
    }

    public function testEmptyValue()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 5,
                2 => 4,
                3 => 3,
                4 => 2,
                5 => 1,
            ],
        ], [
            'gen-div-choice' => 0,
        ]);

        $crawler = $result->getCrawler();

        static::assertSame(200, $result->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('#flash-messages > .card-panel.error')->count());
        static::assertEquals('Veuillez choisir un désordre mental.', trim($crawler->filter('#flash-messages > .card-panel.error')->text()));
    }

    public function testInvalidMentalDisorder()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 5,
                2 => 4,
                3 => 3,
                4 => 2,
                5 => 1,
            ],
        ], [
            'gen-div-choice' => 999999,
        ]);

        $crawler = $result->getCrawler();

        static::assertSame(200, $result->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('#flash-messages > .card-panel.error')->count());
        static::assertEquals('Le désordre mental choisi n\'existe pas.', trim($crawler->filter('#flash-messages > .card-panel.error')->text()));
    }
}
