<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Tests\Crowdfunding;

use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Tests\WebTestCase;
use UserBundle\ConnectApi\UluleClient;
use UserBundle\Crowdfunding\UluleProjectManager;
use UserBundle\Entity\Crowdfunding\Project;
use UserBundle\Entity\User;

class UluleProjectManagerTest extends WebTestCase
{
    private static $clientResults = [
        'getUserProjects' => [],
        'getUserOrders' => [],
    ];

    public function testUpdateProjectsFromUser()
    {
        static::resetDatabase();
        static::bootKernel();
        static::initClientResults();

        $user = $this->getUser();

        $em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');

        $projects = $em->getRepository(Project::class)->findAll();
        static::assertCount(0, $projects);

        $results = static::$clientResults['getUserProjects'];

        $projectManager = $this->getProjectManager(function(MockObject $ululeClient) use ($user, $results) {
            $ululeClient->expects($this->once())
                ->method('getUserProjects')
                ->with($user)
                ->willReturn($results)
            ;
        });

        // Configure the mock

        $projectManager->updateProjectsFromUser($user);

        $projects = $em->getRepository(Project::class)->findAll();
        static::assertCount(1, $projects);

        /** @var User $user */
        $user = $em->getRepository(User::class)->findOneWithProjects($user->getId());

        static::assertNotNull($user);
        static::assertCount(1, $user->getContributions());
    }

    private static function initClientResults()
    {
        static::$clientResults = [
            'getUserProjects' => json_decode(file_get_contents(__DIR__.'/ulule_responses/projects.json'), true),
            'getUserOrders' => json_decode(file_get_contents(__DIR__.'/ulule_responses/orders.json'), true),
        ];
    }

    private function getProjectManager(?\Closure $clientConfiguration): UluleProjectManager
    {
        $kernel = static::$kernel ?: static::bootKernel();

        $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');

        /** @var UluleClient $ululeClient */
        $ululeClient = $this->createMock(UluleClient::class);

        if ($clientConfiguration) {
            $clientConfiguration($ululeClient);
        }

        return new UluleProjectManager($ululeClient, $em);
    }

    private function getUser(): User
    {
        $kernel = static::$kernel ?: static::bootKernel();

        $user = $kernel->getContainer()->get('doctrine.orm.entity_manager')->find(User::class, 1);

        return $user;
    }
}
