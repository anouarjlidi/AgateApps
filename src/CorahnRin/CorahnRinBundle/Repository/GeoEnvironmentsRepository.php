<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\GeoEnvironments;
use Orbitale\Component\DoctrineTools\EntityRepositoryHelperTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class GeoEnvironmentsRepository extends ServiceEntityRepository
{
    use EntityRepositoryHelperTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GeoEnvironments::class);
    }
}
