<?php

namespace EsterenMaps\MapsBundle\Repository;

use Doctrine\ORM\Query;
use EsterenMaps\MapsBundle\Entity\Routes;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;

class RoutesRepository extends BaseRepository
{

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
            $a = array();
            foreach ($result as $route) {
                $a[$asArray ? $route['id'] : $route->getId()] = $route;
            }
            $result = $a;
        }
        return $result;
    }
}
