<?php

namespace EsterenMaps\MapsBundle\Repository;

use Doctrine\ORM\Query;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class RoutesTypesRepository extends BaseRepository
{
    /**
     * @param array $ids
     * @return RoutesTypes[]
     */
    public function findNotInIds(array $ids)
    {
        $qb = $this->createQueryBuilder('rt');

        if (count($ids)) {
            $qb
                ->where('rt.id NOT IN (:ids)')
                ->setParameter(':ids', $ids)
            ;
        }

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}