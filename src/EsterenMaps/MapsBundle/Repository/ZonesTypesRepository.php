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

class ZonesTypesRepository extends BaseRepository
{
    public function findForApi()
    {
        $query = $this->createQueryBuilder('zone_type')
            ->select('
                zone_type.id,
                zone_type.name,
                zone_type.description,
                zone_type.color,
                zoneParent.id as parent_id
            ')
            ->leftJoin('zone_type.parent', 'zoneParent')
            ->indexBy('zone_type', 'zone_type.id')
            ->getQuery()
        ;

        $query->useResultCache(true, 3600);

        return $query->getArrayResult();
    }
}
