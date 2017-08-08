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

/**
 * MarkersRepository.
 */
class MarkersRepository extends BaseRepository
{
    public function findForApiByMap($mapId)
    {
        $query = $this->createQueryBuilder('marker')
            ->select('
                marker.id,
                marker.name,
                marker.description,
                marker.latitude,
                marker.longitude,
                markerType.id as marker_type,
                markerFaction.id as faction
            ')
            ->leftJoin('marker.map', 'map')
            ->leftJoin('marker.markerType', 'markerType')
            ->leftJoin('marker.faction', 'markerFaction')
            ->where('map.id = :id')
            ->setParameter('id', $mapId)
            ->indexBy('marker', 'marker.id')
            ->getQuery()
        ;

        $query->useResultCache(true, 3600);

        return $query->getArrayResult();
    }
}
