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
use Symfony\Component\HttpFoundation\Session\Session;

trait StepsWithDomainsTrait
{
    /**
     * These should be freely changed when inside a test, because bigger logics are needed sometimes.
     * This method only guarantees a working base requirement.
     *
     * @return array
     */
    protected function getValidRequirements(): array
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

    protected function getClientWithRequirements($requirements): Client
    {
        /** @var Client $client */
        $client = $this->getClient();

        /** @var Session $session */
        $session = $client->getContainer()->get('session');
        $session->set('character', $requirements);
        $session->save();

        return $client;
    }

    protected function assertSessionEquals(array $domains, int $remaining = 1, Client $client)
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
