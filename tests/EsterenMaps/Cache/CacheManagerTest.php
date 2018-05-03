<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\EsterenMaps\Cache;

use Doctrine\ORM\EntityManagerInterface;
use EsterenMaps\DataFixtures\ORM\RoutesFixtures;
use EsterenMaps\Entity\Routes;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector;
use Symfony\Component\VarDumper\Cloner\Data;
use Tests\WebTestCase as PiersTestCase;

class CacheManagerTest extends WebTestCase
{
    use PiersTestCase;

    public function testdUpdatingRouteShouldClearMapsCache()
    {
        static::resetDatabase();

        /** @see RoutesFixtures::getSimplerCanvasRoutes for route 701 details */
        $routeId = 700;
        $coordinates = '[{"lat":"0","lng":"0"},{"lat":"10","lng":"10"},{"lat":"0","lng":"10"}]';

        /**
         * Here we only change coordinates for greater distance.
         */
        $jsonPayload = json_encode(
            [
                'map'            => 1,
                'name'           => 'From 0,0 to 0,10',
                'coordinates'    => $coordinates,
                'description'    => 'Test route description',
                'routeType'      => 1,
                'markerStart'    => 700,
                'markerEnd'      => 701,
                'faction'        => null,
                'guarded'        => false,
                'forcedDistance' => null,
            ]
        );

        $client = $this->getClient('api.esteren.dev', [], ['ROLE_ADMIN']);
        $client->enableProfiler();

        $client->request('POST', "/fr/routes/$routeId", [], [], [], $jsonPayload);

        /** @var Routes $route */
        $route = $client
            ->getContainer()
            ->get(EntityManagerInterface::class)
            ->find(Routes::class, $routeId);
        static::assertNotNull($route);
        static::assertSame(700, $route->getId());
        static::assertSame($coordinates, $route->getCoordinates());
        static::assertSame(120, $route->getDistance());

        $profile = $client->getProfile();

        /** @var LoggerDataCollector $loggerDataCollector */
        $loggerDataCollector = $profile->getCollector('logger');
        $loggerDataCollector->lateCollect();

        /*
         * Retrieve log item from collector.
         * This is the way we know whether CacheManager was triggered or not.
         */
        $logToCheck = null;
        foreach ($loggerDataCollector->getLogs() as $log) {
            if ($log instanceof Data) {
                $log = $log->getValue(true);
            }
            if (($log['message'] ?? '') === 'Clearing doctrine cache') {
                if ($logToCheck) {
                    static::fail('Seems that cache clear log was fired twice or more.');
                }

                $logToCheck = $log;
            }
        }

        static::assertNotNull($logToCheck, 'Log was not fired, it means that cache manager was not triggered.');
    }
}
