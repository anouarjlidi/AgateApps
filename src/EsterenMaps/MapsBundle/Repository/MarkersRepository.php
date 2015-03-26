<?php
namespace EsterenMaps\MapsBundle\Repository;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use Pierstoval\Bundle\ToolsBundle\Repository\BaseRepository;
use EsterenMaps\MapsBundle\Entity\Maps;

/**
 * MarkersRepository
 */
class MarkersRepository extends BaseRepository {

    /**
     * Get all markers with their routes (start/end) linked to a specific map.
     * @param Maps $map
     * @return array
     */
    public function getAllWithRoutesArray(Maps $map, TransportTypes $transportType = null) {

        $parameters = array();

        $dql = "
            SELECT
                markers,
                routesStart,
                    markerStartStart,
                    markerEndStart,
                routesEnd,
                    markerStartEnd,
                    markerEndEnd

            FROM {$this->_entityName} markers

            LEFT JOIN markers.routesStart routesStart
                LEFT JOIN routesStart.markerStart markerStartStart
                LEFT JOIN routesStart.markerEnd markerEndStart

            LEFT JOIN markers.routesEnd routesEnd
                LEFT JOIN routesEnd.markerStart markerStartEnd
                LEFT JOIN routesEnd.markerEnd markerEndEnd
        ";

        if ($transportType) {
            $dql .= "
            INNER JOIN routesStart.routeType routesStartTypes
                INNER JOIN routesStartTypes.transports routesStartTypesTransports

            INNER JOIN routesEnd.routeType routesEndTypes
                INNER JOIN routesEndTypes.transports routesEndTypesTransports
            ";
        }

        $dql .= "
            WHERE markers.map = :map
        ";

        if ($transportType) {
            $dql .= '
                AND routesStartTypesTransports.transportType = :transport
                AND routesEndTypesTransports.transportType = :transport
            ';
            $parameters['transport'] = $transportType->getId();
        }

        $parameters['map'] = $map->getId();

        $results = $this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameters($parameters)
            ->getArrayResult()
        ;

        dump($this
            ->getEntityManager()
            ->createQuery($dql)
            ->setParameters($parameters)->getSQL());

        dump($results);
        exit;

        $markers = array();

        foreach ($results as $result) {
            $markers[$result['id']] = $result;
        }

        return $markers;
    }
}