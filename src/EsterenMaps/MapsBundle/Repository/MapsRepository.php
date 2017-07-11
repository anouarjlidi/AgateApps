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
     * @return array[]
     */
    public function findForMenu()
    {
        return $this->_em->createQueryBuilder()
            ->select('map.name, map.nameSlug')
            ->from($this->_entityName, 'map')
            ->getQuery()->getArrayResult()
        ;
    }

    public function findForApi($id)
    {
        $query = $this->createQueryBuilder('map')
            ->select('
                map.id,
                map.name,
                map.nameSlug as name_slug,
                map.image,
                map.description,
                map.maxZoom as max_zoom, 
                map.startZoom as start_zoom, 
                map.startX as start_x, 
                map.startY as start_y, 
                map.bounds, 
                map.coordinatesRatio as coordinates_ratio
            ')
            ->where('map.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
        ;

        $query->useQueryCache(true);
        $query->useResultCache(true);
        $query->setResultCacheLifetime(10);

        return $query->getOneOrNullResult($query::HYDRATE_ARRAY);
    }
}
