<?php

namespace EsterenMaps\MapsBundle\Repository;

use Doctrine\ORM\Query;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class RoutesRepository extends BaseRepository
{
    /**
     * @param Maps|int       $map
     * @param TransportTypes $transportType
     *
     * @return array[]
     */
    public function findForDirections($map, TransportTypes $transportType = null)
    {
        $qb = $this
            ->createQueryBuilder('route')
            ->select('
                route.id,
                route.name,
                route.distance,
                route.forcedDistance,
                route.coordinates,
                route.guarded,
                
                markerStart.id as markerStartId,
                markerStart.name as markerStartName,
                
                markerEnd.id as markerEndId,
                markerEnd.name as markerEndName,
                
                routeType.id,
                routeType.name,
                
                transportType.id,
                transportType.name,
                transportType.slug,
                transportType.speed
            ')
            ->leftJoin('route.markerStart', 'markerStart')
            ->leftJoin('route.markerEnd', 'markerEnd')
            ->innerJoin('route.routeType', 'routeType')
            ->innerJoin('routeType.transports', 'transports')
            ->innerJoin('transports.transportType', 'transportType')
            ->indexBy('route', 'route.id')
            ->where('route.map = :map')
                ->setParameter('map', $map)
        ;

        if ($transportType) {
            // Don't get route where transport type is not available or when speed is zero.
            $qb
                ->andWhere('transportType = :transportType OR (transportType != :transportType AND transports.percentage > 0)')
                ->setParameter('transportType', $transportType)
            ;
        }

        return $qb
            ->getQuery()->getArrayResult()
        ;
    }

    /**
     * @param array $ids
     * @param bool  $sortByIds
     * @param bool  $asArray
     *
     * @return array[]|Routes[]
     */
    public function findByIds(array $ids, $sortByIds = false, $asArray = true)
    {
        /** @var array[]|Routes[] $result */
        $result = $this->_em
            ->createQuery("
                SELECT
                route, routeType, transportsModifier
                FROM {$this->_entityName} route
                LEFT JOIN route.routeType routeType
                    LEFT JOIN routeType.transports transportsModifier
                        LEFT JOIN transportsModifier.transportType transportType
                WHERE route.id IN (:ids)
            ")
            ->setParameter(':ids', $ids)
            ->getResult($asArray ? Query::HYDRATE_ARRAY : Query::HYDRATE_OBJECT)
        ;

        if ($sortByIds) {
            $a = [];
            foreach ($result as $route) {
                $a[$asArray ? $route['id'] : $route->getId()] = $route;
            }
            $result = $a;
        }

        return $result;
    }
}
