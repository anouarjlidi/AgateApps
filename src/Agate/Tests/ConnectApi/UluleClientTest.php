<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\Tests\ConnectApi;

use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\WebTestCase as PiersTestCase;
use Agate\ConnectApi\UluleClient;
use Agate\Entity\User;

class UluleClientTest extends WebTestCase
{
    use PiersTestCase;

    protected static $clientResults;

    public function testUluleClientProjects()
    {
        $user = new User();
        $user->setUluleId(1);
        $user->setUluleUsername('user');
        $user->setUluleApiToken('token');

        $client = $this->createUluleClient();

        $ululeProjects = $client->getUserProjects($user);

        static::assertSame(static::$clientResults['projects'], $ululeProjects);
    }

    private static function initClientResults()
    {
        if (static::$clientResults['getUserProjects']) {
            return;
        }

        static::$clientResults = [
            'projects' => json_decode(file_get_contents(__DIR__.'/ulule_responses/projects.json'), true),
            'orders' => json_decode(file_get_contents(__DIR__.'/ulule_responses/orders.json'), true),
        ];
    }

    private function createUluleClient()
    {
        static::initClientResults();

        $cache = new ArrayAdapter();
        $item = $cache->getItem('ulule_projects.user_1');
        $item->set(static::$clientResults['projects']);
        $cache->save($item);

        return new UluleClient(new NullLogger(), $cache);
    }
}
