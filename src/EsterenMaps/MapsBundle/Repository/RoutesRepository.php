<?php

namespace EsterenMaps\MapsBundle\Repository;

use Doctrine\ORM\Query;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use EsterenMaps\MapsBundle\Hydrator\DirectionsRouteHydrator;
use EsterenMaps\MapsBundle\Model\DirectionRoute;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class RoutesRepository extends BaseRepository
{
    /**
     * @param Maps|int       $map
     * @param TransportTypes $transportType
     *
     * @return DirectionRoute[]
     */
    public function findForDirections($map, TransportTypes $transportType = null)
    {
        $qb = $this
            ->createQueryBuilder('route')
            ->select('
                route,
                routeType,
                markerStart,
                markerEnd,
                transports,
                transportType
            ')
            ->innerJoin('route.markerStart', 'markerStart')
            ->innerJoin('route.markerEnd', 'markerEnd')
            ->innerJoin('route.routeType', 'routeType')
                ->innerJoin('routeType.transports', 'transports')
                    ->innerJoin('transports.transportType', 'transportType')
            ->indexBy('route', 'route.id')
            ->where('route.map = :map')
                ->setParameter('map', $map->getId())
        ;

        // Prepare custom hydration system
        $this->_em->getConfiguration()->addCustomHydrationMode('directions_route', DirectionsRouteHydrator::class);

        /** @var DirectionRoute[] $directionRoutes */
        $directionRoutes = $qb->getQuery()->getResult('directions_route');

        if (null !== $transportType) {
            // Remove each route on which current transport has speed equal to zero
            foreach ($directionRoutes as $k => $directionRoute) {
                foreach ($directionRoute->getTransports() as $resultTransport) {
                    if (
                        $resultTransport->getId() === $transportType->getId()
                        && $resultTransport->getPercentage() === 0.0
                    ) {
                        unset($directionRoutes[$k]);
                        break;
                    }
                }
            }
        }

        return $directionRoutes;
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
