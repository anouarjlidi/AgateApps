<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\CorahnRin\Step;

class Step08WaysTest extends AbstractStepTest
{
    public function testValidWays()
    {
        $ways = [
            '1' => 1,
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
        ];
        $result = $this->submitAction([], [
            'ways' => $ways,
        ]);

        static::assertSame(302, $result->getResponse()->getStatusCode());
        static::assertTrue($result->getResponse()->isRedirect('/fr/character/generate/09_traits'));
        static::assertSame([$this->getStepName() => $ways], $result->getSession()->get('character.corahn_rin'));
    }

    public function testWaysSumIsFiveOnly()
    {
        $ways = [
            '1' => 1,
            '2' => 1,
            '3' => 1,
            '4' => 1,
            '5' => 1,
        ];
        $result = $this->submitAction([], [
            'ways' => $ways,
        ]);

        $crawler = $result->getCrawler();

        static::assertSame(200, $result->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('#flash-messages > .card-panel.error')->count());
        $nodeText = trim($crawler->filter('#flash-messages > .card-panel.error')->text());
        static::assertEquals('Veuillez indiquer vos scores de Voies.', $nodeText);
    }

    public function testWaysSumIsSuperiorToFiveButInferiorToFifteen()
    {
        $ways = [
            '1' => 1,
            '2' => 1,
            '3' => 1,
            '4' => 1,
            '5' => 2,
        ];
        $result = $this->submitAction([], [
            'ways' => $ways,
        ]);

        $crawler = $result->getCrawler();

        static::assertSame(200, $result->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('#flash-messages > .card-panel.warning')->count());
        $nodeText = trim($crawler->filter('#flash-messages > .card-panel.warning')->text());
        static::assertEquals('La somme des voies doit être égale à 15. Merci de corriger les valeurs de certaines voies.', $nodeText);
    }

    public function testNoWayHasScoreOfOneOrFive()
    {
        $ways = [
            '1' => 3,
            '2' => 3,
            '3' => 3,
            '4' => 3,
            '5' => 3,
        ];
        $result = $this->submitAction([], [
            'ways' => $ways,
        ]);

        $crawler = $result->getCrawler();

        static::assertSame(200, $result->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('#flash-messages > .card-panel.warning')->count());
        $nodeText = trim($crawler->filter('#flash-messages > .card-panel.warning')->text());
        static::assertEquals('Au moins une des voies doit avoir un score de 1 ou de 5.', $nodeText);
    }

    public function testWaysBeyondRange()
    {
        $ways = [
            '1' => 1,
            '2' => 1,
            '3' => 2,
            '4' => 2,
            '5' => 6,
        ];
        $result = $this->submitAction([], [
            'ways' => $ways,
        ]);

        $crawler = $result->getCrawler();

        static::assertSame(200, $result->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('#flash-messages > .card-panel.error')->count());
        $nodeText = trim($crawler->filter('#flash-messages > .card-panel.error')->text());
        static::assertEquals('Les voies doivent être comprises entre 1 et 5.', $nodeText);
    }

    public function testInexistentWays()
    {
        $client = $this->getClient();

        $crawler = $client->request('POST', '/fr/character/generate/'.$this->getStepName(), [
            'ways' => [
                '10' => 1,
                '20' => 1,
                '30' => 2,
                '40' => 2,
                '50' => 6,
            ],
        ]);

        static::assertSame(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
        static::assertSame(1, $crawler->filter('#flash-messages > .card-panel.error')->count());
        $nodeText = preg_replace('~(\\r)?\\n\s+~', '', trim($crawler->filter('#flash-messages > .card-panel.error')->text()));
        static::assertEquals('Erreur dans le formulaire. Merci de vérifier les valeurs soumises.Les voies doivent être comprises entre 1 et 5.', $nodeText);
    }
}
