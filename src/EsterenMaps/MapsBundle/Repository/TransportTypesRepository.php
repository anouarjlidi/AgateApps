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

class TransportTypesRepository extends BaseRepository
{
    public function findForApi()
    {
        $query = $this->createQueryBuilder('transport_type')
            ->select('
                transport_type.id,
                transport_type.name,
                transport_type.slug,
                transport_type.description,
                transport_type.speed
            ')
            ->indexBy('transport_type', 'transport_type.id')
            ->getQuery()
        ;

        $query->useResultCache(true, 3600);

        return $query->getArrayResult();
    }
}
