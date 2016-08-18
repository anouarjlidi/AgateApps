<?php

namespace EsterenMaps\MapsBundle\Repository;

use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;
use EsterenMaps\MapsBundle\Entity\Maps;

/**
 * MarkersRepository.
 */
class MarkersRepository extends BaseRepository
{

    /**
     * @param array $ids
     *
     * @return array[]|Markers[]
     */
    public function findByIds(array $ids)
    {
        return $this->_em
            ->createQuery("
                SELECT
                marker, markerType, faction
                FROM {$this->_entityName} marker
                LEFT JOIN marker.markerType markerType
                LEFT JOIN marker.faction faction
                INDEX BY marker.id
                WHERE marker.id IN (:ids)
            ")
            ->setParameter(':ids', $ids)
            ->getArrayResult()
        ;
    }
}
