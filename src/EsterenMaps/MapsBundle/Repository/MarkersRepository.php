<?php
namespace EsterenMaps\MapsBundle\Repository;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use Orbitale\Component\DoctrineTools\BaseEntityRepository as BaseRepository;
use EsterenMaps\MapsBundle\Entity\Maps;

/**
 * MarkersRepository
 */
class MarkersRepository extends BaseRepository {

    /**
     * Get all markers with their routes (start/end) linked to a specific map.
     * @param Maps           $map
     * @param TransportTypes $transportType
     * @return array
     */
    public function getAllWithRoutesArray(Maps $map, TransportTypes $transportType = null) {

        $parameters = array();

        $dql = "
            SELECT
                markers,

                routesStart,
                routesEnd,

                markerStartStart,
                markerStartEnd,

                markerEndStart,
                markerEndEnd

                ".($transportType?"
                    ,routesStartTypesTransports
                    ,routesEndTypesTransports
                ":"")."

            FROM {$this->_entityName} markers

            LEFT JOIN markers.routesStart routesStart
                LEFT JOIN routesStart.markerStart markerStartStart
                LEFT JOIN routesStart.markerEnd markerEndStart

            LEFT JOIN markers.routesEnd routesEnd
                LEFT JOIN routesEnd.markerStart markerStartEnd
                LEFT JOIN routesEnd.markerEnd markerEndEnd

            ".($transportType?"
                LEFT JOIN routesStart.routeType routesStartTypes
                LEFT JOIN routesStartTypes.transports routesStartTypesTransports
                    WITH routesStartTypesTransports.transportType = :transport

                LEFT JOIN routesStart.routeType routesEndTypes
                LEFT JOIN routesEndTypes.transports routesEndTypesTransports
                    WITH routesEndTypesTransports.transportType = :transport
            ":"")."

            WHERE markers.map = :map

            ".($transportType?"
                HAVING
                        (routesStartTypesTransports.percentage != 0 OR routesStartTypesTransports.percentage IS NULL)
                    AND (routesEndTypesTransports.percentage   != 0 OR routesEndTypesTransports.percentage   IS NULL)
            ":"")."
        ";

        if ($transportType) {
            $parameters['transport'] = $transportType->getId();
        }

        $parameters['map'] = $map->getId();

        $query = $this->_em
            ->createQuery($dql)
            ->setParameters($parameters)
        ;

        $results = $query->getArrayResult();

        $markers = array();

        foreach ($results as $result) {
            $markers[$result['id']] = $result;
        }

        return $markers;
    }
}