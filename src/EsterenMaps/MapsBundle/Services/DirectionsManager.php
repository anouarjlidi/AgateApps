<?php

namespace EsterenMaps\MapsBundle\Services;

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use EsterenMaps\MapsBundle\Repository\MarkersRepository;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Uses Dijkstra algorithm to calculate a path between two markers.
 */
class DirectionsManager
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var TwigEngine
     */
    protected $templating;

    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @var int
     */
    protected $cacheTTL;

    /**
     * @var bool
     */
    protected $debug;

    /**
     * @param string        $cacheDir
     * @param int           $cacheTTL
     * @param bool          $debug
     * @param EntityManager $entityManager
     * @param Serializer    $serializer
     *
     * @throws \RuntimeException If the cache directory cannot be created.
     */
    public function __construct($cacheDir, $cacheTTL, $debug, EntityManager $entityManager, Serializer $serializer, TwigEngine $templating)
    {
        $this->cacheDir = rtrim($cacheDir, '/\\');
        if (!is_dir($this->cacheDir)) {
            if (!@mkdir($this->cacheDir, 0777, true) && !is_dir($this->cacheDir)) {
                // This trick allows checking the directory first, then create it, and then re-check it if an error occured.
                throw new \RuntimeException('Could not create cache directory for directions.');
            }
        }
        $this->cacheTTL = $cacheTTL;
        $this->debug = $debug;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->templating = $templating;
    }

    /**
     * @param Maps           $map
     * @param Markers        $start
     * @param Markers        $end
     * @param int            $hoursPerDay
     * @param TransportTypes $transportType
     *
     * @return array
     */
    public function getDirections(Maps $map, Markers $start, Markers $end, $hoursPerDay = 7, TransportTypes $transportType = null)
    {
        $cacheFile = $this->getCacheFile($map, $start, $end, $transportType);
        $exists = file_exists($cacheFile) && filemtime($cacheFile) > (time() - $this->cacheTTL);

        if (true === $exists && !$this->debug) {
            $directions = json_decode(file_get_contents($cacheFile), true);
        } else {
            $directions = $this->doGetDirections($map, $start, $end, $hoursPerDay, $transportType);

            $jsonString = $this->serializer->serialize($directions, 'json', $this->createSerializationContext());

            // Make the directions a full array
            $directions = json_decode($jsonString, true);

            // Save in the cache file
            file_put_contents($cacheFile, $jsonString);
        }

        return $directions;
    }

    /**
     * @param Maps           $map
     * @param Markers        $start
     * @param Markers        $end
     * @param int            $hoursPerDay
     * @param TransportTypes $transportType
     *
     * @return array
     */
    protected function doGetDirections(Maps $map, Markers $start, Markers $end, $hoursPerDay = 7, TransportTypes $transportType = null)
    {

        /** @var MarkersRepository $repo */
        $repo = $this->entityManager->getRepository('EsterenMapsBundle:Markers');

        $allMarkers = $repo->getAllWithRoutesArray($map, $transportType);

        $nodes = [];
        $edges = [];

        /*
         * Formatage des noeuds et des arcs pour une exploitation plus simple par l'algo de dijkstra.
         * Nous avons ici une liste de marqueurs "start" et "end", ainsi que de routes
         *   nous voulons des noeuds (marqueurs) et des arêtes (routes).
         */
        foreach ($allMarkers as $marker) {
            $markerId = (int) $marker['id'];
            $nodes[$markerId] = [
                'id' => $markerId,
                'name' => $marker['name'],
                'neighbours' => [],
            ];
            foreach ($marker['routesStart'] as $route) {
                $routeId = (int) $route['id'];
                $nodes[$markerId]['neighbours'][$routeId] = [
                    'distance' => $route['distance'],
                    'end' => $route['markerEnd']['id'],
                ];
                if (!array_key_exists($routeId, $edges)) {
                    $edges[$routeId] = [
                        'id' => $routeId,
                        'name' => $route['name'],
                        'distance' => $route['distance'],
                        'vertices' => [
                            'start' => $markerId,
                            'end' => $route['markerEnd']['id'],
                        ],
                    ];
                }
            }
            foreach ($marker['routesEnd'] as $route) {
                $routeId = (int) $route['id'];
                $nodes[$markerId]['neighbours'][$routeId] = [
                    'distance' => $route['distance'],
                    'end' => $route['markerStart']['id'],
                ];
                if (!array_key_exists($routeId, $edges)) {
                    $edges[$routeId] = [
                        'id' => $routeId,
                        'name' => $route['name'],
                        'distance' => $route['distance'],
                        'vertices' => [
                            'start' => $route['markerStart']['id'],
                            'end' => $markerId,
                        ],
                    ];
                }
            }
        }

        $paths = $this->dijkstra($nodes, $edges, (int) $start->getId(), (int) $end->getId());

        $routesIds = array_values($paths);
        $markersArray = $this->entityManager->getRepository('EsterenMapsBundle:Markers')->findByIds(array_keys($paths));
        $routesArray = $this->entityManager->getRepository('EsterenMapsBundle:Routes')->findByIds($routesIds, true, true);
        $routesObjects = $this->entityManager->getRepository('EsterenMapsBundle:Routes')->findByIds($routesIds, false, false);

        $paths = $this->checkTransportType($paths, $routesObjects, $transportType);

        $steps = [];

        foreach ($paths as $markerId => $routeId) {
            $marker = $markersArray[$markerId];
            $marker['route'] = $routeId ? $routesArray[$routeId] : null;
            unset(
                $marker['routesStart'],
                $marker['routesEnd'],
                $marker['createdAt'],
                $marker['updatedAt'],
                $marker['deletedAt'],
                $marker['faction']['createdAt'],
                $marker['faction']['updatedAt'],
                $marker['faction']['deletedAt'],
                $marker['markerType']['createdAt'],
                $marker['markerType']['updatedAt'],
                $marker['markerType']['deletedAt'],
                $marker['route']['createdAt'],
                $marker['route']['updatedAt'],
                $marker['route']['deletedAt'],
                $marker['route']['routeType']['createdAt'],
                $marker['route']['routeType']['updatedAt'],
                $marker['route']['routeType']['deletedAt'],
                $marker['route']['routeType']['transports'],
                $marker['route']['markerStart'],
                $marker['route']['markerEnd']
            );
            $steps[] = $marker;
        }

        return $this->getDataArray($start, $end, $steps, $routesObjects, $hoursPerDay, $transportType);
    }

    /**
     * Applies Dijkstra algorithm to calculate minimal distance between source and target.
     *
     * Implementation of http://codereview.stackexchange.com/questions/75641/dijkstras-algorithm-in-php
     *
     * @link http://codereview.stackexchange.com/questions/75641/dijkstras-algorithm-in-php
     *
     * @param array $nodes
     * @param array $edges
     * @param int   $start
     * @param int   $end
     *
     * @return array
     */
    protected function dijkstra($nodes, $edges, $start, $end)
    {
        $distances = [];

        foreach ($nodes as $id => $node) {
            foreach ($node['neighbours'] as $nid => $neighbour) {
                $distances[$id][$neighbour['end']] = [
                    'edge' => $edges[$nid],
                    'distance' => $neighbour['distance'],
                ];
            }
        }

        //initialize the array for storing
        $S = [];//the nearest path with its parent and weight
        $Q = [];//the left nodes without the nearest path
        foreach (array_keys($distances) as $val) {
            $Q[$val] = INF;
        }
        $Q[$start] = 0;

        //start calculating
        while (0 !== count($Q)) {
            $min = array_search(min($Q), $Q, true);//the most min weight
            if ($min === $end) {
                break;
            }
            foreach ($distances[$min] as $key => $val) {
                $dist = $val['distance'];

                if (!empty($Q[$key]) && $Q[$min] + $dist < $Q[$key]) {
                    $Q[$key] = $Q[$min] + $dist;
                    $S[$key] = [$min, $Q[$key]];
                }
            }
            unset($Q[$min]);
        }

        if (!array_key_exists($end, $S)) {
            return [];
        }

        $path = [];
        $pos = $end;
        while ($pos !== $start) {
            $path[] = $pos;
            $pos = $S[$pos][0];
        }
        $path[] = $start;
        $path = array_reverse($path);

        $realPath = [];

        foreach ($path as $k => $nodeId) {
            $next = isset($path[$k + 1]) ? $path[$k + 1] : null;

            $realPath[$nodeId] = null;

            if ($next) {
                $dist = INF;
                $realEdge = null;

                foreach ($nodes[$nodeId]['neighbours'] as $edgeId => $edge) {
                    if ($edge['distance'] < $dist && $edge['end'] === $next) {
                        $realEdge = $edges[$edgeId];
                        $dist = $edge['distance'];
                    }
                }

                if ($realEdge) {
                    $realPath[$nodeId] = $realEdge['id'];
                }
            }
        }

        return $realPath;
    }

    /**
     * @param Maps           $map
     * @param Markers        $start
     * @param Markers        $end
     * @param TransportTypes $transportType
     *
     * @return array
     */
    protected function getCacheFile(Maps $map, Markers $start, Markers $end, TransportTypes $transportType = null)
    {
        $hash = md5($map->getId().$start->getId().$end->getId().($transportType ?: ''));

        return $this->cacheDir.'/'.$hash.'.json';
    }

    /**
     * @param Markers        $from
     * @param Markers        $to
     * @param array[]        $directions
     * @param Routes[]       $routes
     * @param int            $hoursPerDay
     * @param TransportTypes $transport
     *
     * @return array
     */
    protected function getDataArray(Markers $from, Markers $to, array $directions, array $routes, $hoursPerDay = 7, TransportTypes $transport = null)
    {
        $distance = 0;
        $NE = [];
        $SW = [];

        foreach ($directions as $step) {
            $distance += ($step['route'] ? $step['route']['distance'] : 0);
            if ($step['route']) {
                $coords = json_decode($step['route']['coordinates'], true);
                foreach ($coords as $latLng) {
                    if (!isset($NE['lat']) || ($NE['lat'] < $latLng['lat'])) {
                        $NE['lat'] = $latLng['lat'];
                    }
                    if (!isset($NE['lng']) || ($NE['lng'] < $latLng['lng'])) {
                        $NE['lng'] = $latLng['lng'];
                    }
                    if (!isset($SW['lat']) || ($SW['lat'] > $latLng['lat'])) {
                        $SW['lat'] = $latLng['lat'];
                    }
                    if (!isset($SW['lng']) || ($SW['lng'] > $latLng['lng'])) {
                        $SW['lng'] = $latLng['lng'];
                    }
                }
            }
        }

        $data = [
            'found' => count($directions) > 0,
            'path_view' => null,
            'duration_raw' => null,
            'duration_real' => null,
            'transport' => json_decode($this->serializer->serialize($transport, 'json', $this->createSerializationContext()), true),
            'bounds' => ['northEast' => $NE, 'southWest' => $SW],
            'total_distance' => $distance,
            'number_of_steps' => count($directions) ? (count($directions) - 2) : 0,
            'start' => $from,
            'end' => $to,
            'path' => $directions,
        ];

        $data['duration_raw'] = $this->getTravelDuration($routes, $transport, $hoursPerDay, true);
        $data['duration_real'] = $this->getTravelDuration($routes, $transport, $hoursPerDay, false);
        $data['path_view'] = $this->templating->render('@EsterenMapsApi/Maps/path_view.html.twig', $data);

        return $data;
    }

    /**
     * @return SerializationContext
     */
    private function createSerializationContext()
    {
        $serializationContext = new SerializationContext();
        $serializationContext->setSerializeNull(true);

        return $serializationContext;
    }

    /**
     * @param array          $paths
     * @param Routes[]       $routes
     * @param TransportTypes $transportType
     *
     * @return array
     */
    private function checkTransportType(array $paths, array $routes, TransportTypes $transportType = null)
    {
        if (!$transportType) {
            return $paths;
        }

        // Check that the transport have a good value here
        foreach ($routes as $route) {
            if ($route->getRouteType()->getTransport($transportType)->getPercentage() <= 0) {
                return [];
            }
        }

        return $paths;
    }

    /**
     * @param Routes[]       $routes
     * @param TransportTypes $transport
     * @param int            $hoursPerDay
     * @param bool           $raw
     *
     * @return int|null
     */
    private function getTravelDuration(array $routes, TransportTypes $transport, $hoursPerDay = 7, $raw = true)
    {
        if (!$transport) {
            return;
        }

        $total = 0;

        foreach ($routes as $route) {
            $distance = $route->getDistance();
            $transportModifier = null;
            foreach ($route->getRouteType()->getTransports() as $routeTransport) {
                if ($routeTransport->getTransportType()->getId() === $transport->getId()) {
                    $transportModifier = $routeTransport;
                }
            }
            if ($transportModifier) {
                $percentage = (float) $transportModifier->getPercentage();
                if ($transportModifier->isPositiveRatio()) {
                    $speed = $transport->getSpeed() * ($percentage / 100);
                } else {
                    $speed = $transport->getSpeed() * ((100 - $percentage) / 100);
                }
                $hours = $distance / $speed;
                $total += $hours;
            } else {
                continue;
            }
        }

        $hours = (int) floor($total);
        $minutes = (int) ceil(($total - $hours) * 100 * 60 / 100);

        $interval = new \DateInterval('PT'.$hours.'H'.$minutes.'M');
        $start = new \DateTime();
        $end = new \DateTime();
        $end->add($interval);

        // Recreating the interval allows automatic calculation of days/months.
        $interval = $start->diff($end);

        // Get the raw DateInterval format
        if ($raw) {
            return $interval->format('P%yY%mM%dDT%hH%iM0S');
        }

        // Here we'll try to convert hours into a more "realistic" travel time.
        $realisticDays = $total / $hoursPerDay;

        $days = (int) floor($realisticDays);
        $hours = (float) number_format(($realisticDays - $days) * $hoursPerDay, 2);

        return [
            'days' => $days,
            'hours' => $hours,
        ];
    }
}
