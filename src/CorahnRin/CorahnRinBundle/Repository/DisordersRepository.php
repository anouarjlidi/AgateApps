<?php

namespace CorahnRin\CorahnRinBundle\Repository;

use CorahnRin\CorahnRinBundle\Entity\Disorders;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;

class DisordersRepository extends BaseEntityRepository
{
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
