<?php

namespace EsterenMaps\MapsBundle\Repository;

use EsterenMaps\MapsBundle\Entity\Routes;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class RoutesRepository extends BaseRepository {

    /**
     * @param array $ids
     *
     * @param bool  $sortByIds
     *
     * @return array|Routes[]
     */
    public function findByIdsArray(array $ids, $sortByIds = false)
    {
        $result = $this->_em
            ->createQuery("
                SELECT
                route, routeType
                FROM {$this->_entityName} route
                LEFT JOIN route.routeType routeType
                WHERE route.id IN (:ids)
            ")
            ->setParameter(':ids', $ids)
            ->getArrayResult()
        ;
        if ($sortByIds) {
            $a = array();
            foreach ($result as $route) {
                $a[$route['id']] = $route;
            }
            $result = $a;
        }
        return $result;
    }
}
