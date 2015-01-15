<?php
namespace EsterenMaps\MapsBundle\Repository;
use Pierstoval\Bundle\ToolsBundle\Repository\BaseRepository;
use EsterenMaps\MapsBundle\Entity\Maps;

/**
 * MarkersRepository
 */
class MarkersRepository extends BaseRepository {

    public function getAllWithRoutesArray(Maps $map) {

        $dql = '
            SELECT
                markers,
                routesStart,
                    markerStartStart,
                    markerEndStart,
                routesEnd,
                    markerStartEnd,
                    markerEndEnd

            FROM '.$this->getClassName().' markers

            LEFT JOIN markers.routesStart routesStart
                LEFT JOIN routesStart.markerStart markerStartStart
                LEFT JOIN routesStart.markerEnd markerEndStart

            LEFT JOIN markers.routesEnd routesEnd
                LEFT JOIN routesEnd.markerStart markerStartEnd
                LEFT JOIN routesEnd.markerEnd markerEndEnd

            WHERE markers.map = :map
        ';

        $query = $this->getEntityManager()->createQuery($dql)->setParameter('map', $map->getId());

        $results = $query->getArrayResult();

        $markers = array();

        foreach ($results as $result) {
            $markers[$result['id']] = $result;
        }

        return $markers;
    }
}