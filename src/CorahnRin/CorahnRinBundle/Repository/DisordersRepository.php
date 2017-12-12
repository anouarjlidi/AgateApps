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

use CorahnRin\CorahnRinBundle\Entity\Disorders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DisordersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Disorders::class);
    }

    /**
     * @return Disorders[]
     */
    public function findWithWays()
    {
        return $this->createQueryBuilder('disorder')
            ->leftJoin('disorder.ways', 'way')
                ->addSelect('way')
            ->indexBy('disorder', 'disorder.id')
            ->getQuery()->getResult()
        ;
    }
}
