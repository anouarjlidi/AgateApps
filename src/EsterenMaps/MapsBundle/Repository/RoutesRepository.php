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

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use EsterenMaps\MapsBundle\Entity\Routes;
use Doctrine\Common\Persistence\ManagerRegistry;

class RoutesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Routes::class);
    }

    public function findForApiByMap($mapId)
    {
        $query = $this->createQueryBuilder('route')
            ->select('
                route.id,
                route.name,
                route.description,
                route.coordinates,
                route.distance,
                route.forcedDistance as forced_distance,
                route.guarded,
                markerStart.id as marker_start,
                markerEnd.id as marker_end,
                routeFaction.id as faction,
                routeType.id as route_type
            ')
            ->leftJoin('route.map', 'map')
            ->leftJoin('route.markerStart', 'markerStart')
            ->leftJoin('route.markerEnd', 'markerEnd')
            ->leftJoin('route.faction', 'routeFaction')
            ->leftJoin('route.routeType', 'routeType')
            ->where('map.id = :id')
            ->setParameter('id', $mapId)
            ->indexBy('route', 'route.id')
            ->getQuery()
        ;

        $query->useResultCache(true, 3600);

        return $query->getArrayResult();
    }
}
