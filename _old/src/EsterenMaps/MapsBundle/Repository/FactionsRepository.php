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

use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class FactionsRepository extends BaseRepository
{
    public function findForApi()
    {
        $query = $this->createQueryBuilder('faction')
            ->select('
                faction.id,
                faction.name,
                faction.description
            ')
            ->indexBy('faction', 'faction.id')
            ->getQuery()
        ;

        $query->useResultCache(true, 3600);

        return $query->getArrayResult();
    }
}
