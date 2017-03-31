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

class Step09TraitsTest extends AbstractStepTest
{
    public function testWaysDependency()
    {
        $client = $this->getClient();

        $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate'));
    }

    public function testValidSetbacks()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
            ]
        ], $values = [
            'quality' => 6,
            'flaw' => 64,
        ]);

        static::assertSame(302, $result->getResponse()->getStatusCode());
        static::assertTrue($result->getResponse()->isRedirect('/fr/character/generate/10_orientation'));
        static::assertSame($values, $result->getSession()->get('character')[$this->getStepName()]);
    }

    public function testInValidSetbacks()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
            ]
        ], $values = [
            'quality' => 0,
            'flaw' => 0,
        ]);

        static::assertSame(200, $result->getResponse()->getStatusCode());
        static::assertSame(1, $result->getCrawler()->filter('#flash-messages > .card-panel.error')->count());
        static::assertEquals('Les traits de caractère choisis sont incorrects.', trim($result->getCrawler()->filter('#flash-messages > .card-panel.error')->text()));
    }
}
