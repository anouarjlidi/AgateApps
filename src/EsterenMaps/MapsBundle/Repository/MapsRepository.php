<?php

namespace EsterenMaps\MapsBundle\Repository;

use EsterenMaps\MapsBundle\Entity\Maps;
use Orbitale\Component\DoctrineTools\BaseEntityRepository;

class MapsRepository extends BaseEntityRepository
{
    /**
     * @return Maps[]
     */
    public function findAllWithRoutes()
    {
        $qb = $this->createQueryBuilder('map');

        $qb
            ->leftJoin('map.routes', 'route')
                ->addSelect('route')
                ->leftJoin('route.markerStart', 'markerStart')
                    ->addSelect('markerStart')
                ->leftJoin('route.markerEnd', 'markerEnd')
                    ->addSelect('markerEnd')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @return array
     */
    public function findForMenu()
    {
        return $this->_em->createQueryBuilder()
            ->select('map.name, map.nameSlug')
            ->from($this->_entityName, 'map')
            ->getQuery()->getArrayResult()
        ;
    }
}
