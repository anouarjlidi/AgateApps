<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Repository\Crowdfunding;

use Orbitale\Component\DoctrineTools\BaseEntityRepository;
use UserBundle\Entity\Crowdfunding\Project;

class ProjectRepository extends BaseEntityRepository
{
    /**
     * @return Project[]
     */
    public function findWithRewards()
    {
        return $this->createQueryBuilder('project', 'project.id')
            ->leftJoin('project.rewards', 'reward')->addSelect('reward')
            ->leftJoin('reward.variants', 'variant')->addSelect('variant')
            ->getQuery()->getResult()
        ;
    }
}
