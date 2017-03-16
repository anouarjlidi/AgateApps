<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Hydrator;

use Doctrine\ORM\Internal\Hydration\AbstractHydrator;
use EsterenMaps\MapsBundle\Model\DirectionRoute;
use EsterenMaps\MapsBundle\Model\DirectionRouteTransport;

final class DirectionsRouteHydrator extends AbstractHydrator
{
    /**
     * @var array
     */
    private $mapping;

    /**
     * @return DirectionRoute[]
     */
    protected function hydrateAllData()
    {
        $this->initializeMappingAssociations();

        /** @var DirectionRoute[] $results */
        $results = [];

        foreach($this->_stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {

            $routeId = $this->getRowValue($row, 'route.id');

            if (!array_key_exists($routeId, $results)) {
                $results[$routeId] = new DirectionRoute(
                    $this->getRowValue($row, 'route.id'),
                    $this->getRowValue($row, 'route.name'),
                    $this->getRowValue($row, 'route.distance'),
                    $this->getRowValue($row, 'route.forcedDistance'),
                    $this->getRowValue($row, 'route.coordinates'),
                    $this->getRowValue($row, 'route.guarded'),
                    $this->getRowValue($row, 'markerStart.id'),
                    $this->getRowValue($row, 'markerStart.name'),
                    $this->getRowValue($row, 'markerEnd.id'),
                    $this->getRowValue($row, 'markerEnd.name'),
                    $this->getRowValue($row, 'routeType.id'),
                    $this->getRowValue($row, 'routeType.name')
                );
            }

            $results[$routeId]->addTransport(new DirectionRouteTransport(
                $this->getRowValue($row, 'transportType.id'),
                $this->getRowValue($row, 'transportType.name'),
                $this->getRowValue($row, 'transportType.slug'),
                $this->getRowValue($row, 'transportType.speed'),
                $this->getRowValue($row, 'transports.percentage'),
                $this->getRowValue($row, 'transports.positiveRatio')
            ));
        }

        return $results;
    }

    /**
     * Get the mapping associations names instead of sql names.
     */
    private function initializeMappingAssociations()
    {
        $owners = $this->_rsm->columnOwnerMap;
        $mappingFields = $this->_rsm->fieldMappings;

        $finalMapping = [];

        foreach ($owners as $dbKey => $owner) {
            $finalMapping[$owner.'.'.$mappingFields[$dbKey]] = $dbKey;
        }

        $this->mapping = $finalMapping;
    }

    /**
     * @param array  $row
     * @param string $key
     *
     * @return mixed
     */
    private function getRowValue(array $row, $key)
    {
        return $row[$this->mapping[$key]];
    }
}
