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

class MarkersTypesRepository extends BaseRepository
{
    public function findForApi()
    {
        $query = $this->createQueryBuilder('marker_type')
            ->select('
                marker_type.id,
                marker_type.name,
                marker_type.description,
                marker_type.icon,
                marker_type.iconWidth as icon_width,
                marker_type.iconHeight as icon_height,
                marker_type.iconCenterX as icon_center_x,
                marker_type.iconCenterY as icon_center_y
            ')
            ->indexBy('marker_type', 'marker_type.id')
            ->getQuery()
        ;

        $query->useResultCache(true, 3600);

        return $query->getArrayResult();
    }
}
