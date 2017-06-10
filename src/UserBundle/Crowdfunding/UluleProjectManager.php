<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Crowdfunding;

use Doctrine\ORM\EntityManager;
use UserBundle\ConnectApi\UluleClient;
use UserBundle\Entity\Crowdfunding\Contribution;
use UserBundle\Entity\Crowdfunding\Project;
use UserBundle\Entity\Crowdfunding\Reward;
use UserBundle\Entity\Crowdfunding\RewardVariant;
use UserBundle\Entity\User;

class UluleProjectManager
{
    const ULULE_PROJECTS = [
        8021,  // Esteren - Dearg
        10861, // Esteren - Voyages
        23423, // Esteren - Occultisme
        28873, // Vampire - Requiem
        30600, // Vampire - Requiem (2)
        34243, // Dragons
        51014, // 7e mer
    ];

    private $ululeClient;
    private $em;

    public function __construct(UluleClient $ululeClient, EntityManager $em)
    {
        $this->ululeClient = $ululeClient;
        $this->em = $em;
    }

    public function updateProjectsFromUser(User $user): void
    {
        $ululeProjects = $this->ululeClient->getUserProjects($user);

        $this->syncProjects($ululeProjects);
    }

    public function updateUserContributions(User $user): void
    {
        $projects = $this->em->getRepository(Project::class)->findAll(true);
        $rewards = $this->em->getRepository(Reward::class)->findAll(true);

        $orders = $this->ululeClient->getUserOrders($user);

        /**
         * Persist all order rewards
         */
        foreach ($orders as $order) {
            // Only allow Agate's projects
            if (!in_array($order['project_id'], static::ULULE_PROJECTS, true)) {
                continue;
            }

            /**
             * Check order status
             * http://developers.ulule.com/#get-order
             */
            if (!in_array($order['status'], [
                3, // Awaiting confirmation
                4, // Payment completed
                5, // Shipped
                7, // Payment done
            ], true)) {
                continue;
            }

            if (!isset($projects[$order['project_id']])) {
                throw new \RuntimeException('Missing project with id '.$order['project_id']);
            }

            $project = $projects[$order['project_id']];

            $contributionId = $order['id'];
            if ($user->getContributionById($contributionId)) {
                $contribution = $user->getContributionById($contributionId);
            } else {
                $contribution = new Contribution($contributionId, Project::ULULE);
            }
            $contribution
                ->setProject($project)
                ->setUser($user)
                ->resetRewards()
            ;
            $this->em->persist($contribution);

            foreach ($order['items'] as $item) {
                if (!isset($rewards[$item['reward_id']])) {
                    throw new \RuntimeException('Missing reward with id '.$item['reward_id']);
                }

                $reward = $rewards[$item['reward_id']];

                $contribution->addReward($reward);
                $this->em->persist($reward);
            }

            $this->em->persist($contribution);
        }

        $this->em->persist($user);

        $this->em->flush();
    }

    private function syncProjects(array $ululeProjects): void
    {
        $allProjects = $this->em->getRepository(Project::class)->findWithRewards();

        foreach ($ululeProjects as $ululeProject) {
            // Only allow Agate's projects
            if (!in_array($ululeProject['id'], static::ULULE_PROJECTS, true)) {
                continue;
            }

            $projectId = $ululeProject['id'];
            if (isset($allProjects[$projectId])) {
                $project = $allProjects[$projectId];
                $newProject = false;
            } else {
                $project = new Project($projectId, Project::ULULE);
                $newProject = true;
            }
            $project
                ->setName($ululeProject['name_fr'])
                ->setUrl($ululeProject['absolute_url'])
            ;
            $this->em->persist($project);

            foreach ($ululeProject['rewards'] as $ululeReward) {
                $rewardId = $ululeReward['id'];
                if ($newProject) {
                    $reward = new Reward($rewardId, Project::ULULE);
                    $reward->setProject($project);
                } else {
                    $reward = $project->getRewardById($rewardId);
                }
                $reward
                    ->setDescription($ululeReward['description_fr'])
                ;
                $this->em->persist($reward);

                if (isset($ululeReward['variants'])) {
                    foreach ($ululeReward['variants'] as $ululeVariant) {
                        $variantId = $ululeVariant['id'];
                        $variant = $newProject ? new RewardVariant($variantId, Project::ULULE) : $reward->getVariantById($variantId);
                        $variant = $this->em->merge($variant);
                        $variant
                            ->setDescription($ululeVariant['description_fr'])
                            ->setReward($reward)
                        ;

                        $this->em->persist($variant);
                    }
                }

                $this->em->persist($reward);
            }

            $this->em->persist($project);
        }

        $this->em->flush();
    }
}
