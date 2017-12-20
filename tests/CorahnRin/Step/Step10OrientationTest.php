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

use CorahnRin\Data\Orientation;

class Step10OrientationTest extends AbstractStepTest
{
    public function testWaysDependency()
    {
        $client = $this->getClient();

        $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertSame(302, $client->getResponse()->getStatusCode());
        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate'));
    }

    public function testValidInstinctiveOrientation()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 5,
                2 => 4,
                3 => 3,
                4 => 2,
                5 => 1,
            ],
        ]);

        static::assertSame(302, $result->getResponse()->getStatusCode());
        static::assertTrue($result->getResponse()->isRedirect('/fr/character/generate/11_advantages'));
        static::assertSame(Orientation::INSTINCTIVE, $result->getSession()->get('character')[$this->getStepName()]);
    }

    public function testValidRationalOrientation()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
            ],
        ]);

        static::assertSame(302, $result->getResponse()->getStatusCode());
        static::assertTrue($result->getResponse()->isRedirect('/fr/character/generate/11_advantages'));
        static::assertSame(Orientation::RATIONAL, $result->getSession()->get('character')[$this->getStepName()]);
    }

    public function testValidManualInstinctiveOrientation()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 3,
                2 => 4,
                3 => 1,
                4 => 4,
                5 => 3,
            ],
        ], $values = [
            'gen-div-choice' => Orientation::INSTINCTIVE,
        ]);

        static::assertSame(302, $result->getResponse()->getStatusCode());
        static::assertTrue($result->getResponse()->isRedirect('/fr/character/generate/11_advantages'));
        static::assertSame(Orientation::INSTINCTIVE, $result->getSession()->get('character')[$this->getStepName()]);
    }

    public function testValidManualRationalOrientation()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 3,
                2 => 4,
                3 => 1,
                4 => 4,
                5 => 3,
            ],
        ], $values = [
            'gen-div-choice' => Orientation::RATIONAL,
        ]);

        static::assertSame(302, $result->getResponse()->getStatusCode());
        static::assertTrue($result->getResponse()->isRedirect('/fr/character/generate/11_advantages'));
        static::assertSame(Orientation::RATIONAL, $result->getSession()->get('character')[$this->getStepName()]);
    }

    public function testInvalidManualOrientation()
    {
        $result = $this->submitAction([
            '08_ways' => [
                1 => 3,
                2 => 4,
                3 => 1,
                4 => 4,
                5 => 3,
            ],
        ], $values = [
            'gen-div-choice' => 'INVALID',
        ]);

        static::assertSame(200, $result->getResponse()->getStatusCode());
        static::assertSame(1, $result->getCrawler()->filter('#flash-messages > .card-panel.error')->count());
        static::assertEquals('L\'orientation de la personnalité est incorrecte, veuillez vérifier.', trim($result->getCrawler()->filter('#flash-messages > .card-panel.error')->text()));
    }
}
