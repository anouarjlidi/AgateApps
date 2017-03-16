<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Repository;

use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class RoutesTypesRepository extends BaseRepository
{
    /**
     * @param array $ids
     *
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
