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

class Step13PrimaryDomainsTest extends AbstractStepTest
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

        $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertSame(302, $client->getResponse()->getStatusCode());
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
        ];
    }

    public function testVarigal()
    {
        $client = $this->getStepClient(18); // Varigal id in fixtures

        $crawler = $client->request('GET', '/fr/character/generate/'.$this->getStepName());

        static::assertCount(2, $crawler->filter('[data-change="3"].domain-change'));
    }

    /**
     * @param int   $jobId
     * @param int[] $ways
     * @param int[] $advantages
     * @param int[] $disadvantages
     *
     * @return Client
     */
    protected function getStepClient($jobId = 1, array $ways = [1, 2, 3, 4, 5], array $advantages = [], array $disadvantages = [])
    {
        $client = $this->getClient();

        $session = $client->getContainer()->get('session');
        $session->set('character', [
            '02_job' => $jobId,
            '08_ways' => $ways,
            '11_advantages' => [
                'advantages' => $advantages,
                'disadvantages' => $disadvantages,
            ],
        ]);
        $session->save();

        return $client;
    }
}
