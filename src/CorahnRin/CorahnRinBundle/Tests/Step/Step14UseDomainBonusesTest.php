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

use Symfony\Bundle\FrameworkBundle\Client;

class Step14UseDomainBonusesTest extends AbstractStepTest
{
    /**
     * @dataProvider provideInvalidDependencies
     */
    public function testStepDependency($dependencies)
    {
        $client = parent::getClient();

        $session = $client->getContainer()->get('session');
        $session->set('character', $dependencies); // Varigal
        $session->save();

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        $errorMessage = $crawler->filter('head title')->text();

        static::assertSame(302, $client->getResponse()->getStatusCode(), $errorMessage);
        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate'));
    }

    public function provideInvalidDependencies()
    {
        return [
            [[]],
            [['02_job' => 1]],
            [['08_ways' => [1, 2, 3, 4, 5]]],
            [['11_advantages' => []]],
            [['02_job' => 1, '08_ways' => [1, 2, 3, 4, 5]]],
            [['11_advantages' => [], '08_ways' => [1, 2, 3, 4, 5]]],
            [['13_primary_domains' => ['domains' => [],'ost' => 2,'scholar' => null]]],
        ];
    }

    public function testNoBonusesSpent()
    {
        $client = $this->getClientWithRequirements($this->getValidRequirements());

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('#generator_form')->form();

        $client->submit($form);

        static::assertTrue($client->getResponse()->isRedirect('/fr/character/generate/15_domains_spend_exp'));
        $this->assertSessionEquals([], 1, $client);
    }

    public function testPrimaryDomainThrowsError()
    {
        $client = $this->getClientWithRequirements($this->getValidRequirements());

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('#generator_form')->form();

        $form['domains_bonuses[1]'] = 1;

        $crawler = $client->submit($form);

        // Redirection means error
        static::assertSame(200, $client->getResponse()->getStatusCode());
        $flashMessages = $crawler->filter('#flash-messages') ?: '';
        static::assertContains('Certaines valeurs envoyées sont incorrectes, veuillez recommencer (et sans tricher).', $flashMessages ? trim($flashMessages->text()) : '');
    }

    /**
     * These should be freely changed when inside a test, because bigger logics are needed sometimes.
     * This method only guarantees a working base requirement.
     *
     * @return array
     */
    private function getValidRequirements(): array
    {
        return [
            '04_geo' => 1,
            '05_social_class' => [
                'id' => 1,
                'domains' => [
                    5 => 5,
                    8 => 8,
                ],
            ],
            '06_age' => 16,
            '11_advantages' => [
                'advantages' => [],
                'disadvantages' => [],
                'remainingExp' => 100,
            ],
            '13_primary_domains' => [
                'domains' => [
                    1 => 5,
                    2 => 2,
                    3 => 0,
                    4 => 0,
                    5 => 1,
                    6 => 0,
                    7 => 0,
                    8 => 0,
                    9 => 0,
                    10 => 0,
                    11 => 0,
                    12 => 0,
                    13 => 3,
                    14 => 0,
                    15 => 2,
                    16 => 1,
                ],
                'ost' => 2,
                'scholar' => null,
            ],
        ];
    }

    private function getClientWithRequirements($requirements): Client
    {
        $client = parent::getClient();

        $session = $client->getContainer()->get('session');
        $session->set('character', $requirements);
        $session->save();

        return $client;
    }

    private function assertSessionEquals(array $domains, int $remaining = 1, Client $client)
    {
        $finalDomains = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
            9 => 0,
            10 => 0,
            11 => 0,
            12 => 0,
            13 => 0,
            14 => 0,
            15 => 0,
            16 => 0,
        ];

        foreach ($domains as $id => $value) {
            $finalDomains[$id] = $value;
        }

        $results = [
            'domains' => $finalDomains,
            'remaining' => $remaining,
        ];

        static::assertEquals($results, $client->getContainer()->get('session')->get('character')[$this->getStepName()]);
    }
}
