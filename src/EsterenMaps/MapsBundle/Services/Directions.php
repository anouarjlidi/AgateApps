<?php

namespace EsterenMaps\MapsBundle\Services;

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use EsterenMaps\MapsBundle\Repository\MarkersRepository;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Directions
 * Utilise l'algorithme de Dijkstra pour calculer le trajet entre deux marqueurs
 * @package EsterenMaps\MapsBundle\Services
 */
class Directions
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
     * @var string
     */
    protected $cacheDir;

    /**
     * @var integer
     */
    protected $cacheTTL;

    /**
     * @var boolean
     */
    protected $debug;

    /**
     * @param string        $cacheDir
     * @param integer       $cacheTTL
     * @param boolean       $debug
     * @param EntityManager $entityManager
     * @param Serializer    $serializer
     */
    public function __construct($cacheDir, $cacheTTL, $debug, EntityManager $entityManager, Serializer $serializer)
    {
        $this->cacheDir = rtrim($cacheDir, '/\\');
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
        $this->cacheTTL      = $cacheTTL;
        $this->debug         = $debug;
        $this->entityManager = $entityManager;
        $this->serializer    = $serializer;
    }

    /**
     * @param Maps           $map
     * @param Markers        $start
     * @param Markers        $end
     * @param TransportTypes $transportType
     *
     * @return array
     */
    public function getDirections(Maps $map, Markers $start, Markers $end, TransportTypes $transportType = null)
    {
        $cacheFile = $this->getCacheFile($map, $start, $end, $transportType);
        $exists    = file_exists($cacheFile) && filemtime($cacheFile) > (time() - $this->cacheTTL);

        if (true === $exists && !$this->debug) {
            $directions = file_get_contents($cacheFile);
        } else {
            $directions = $this->doGetDirections($map, $start, $end, $transportType);
            $datas = json_encode(json_decode($this->serializer->serialize($directions, 'json')), $this->debug ? 480 : 0);
            file_put_contents($cacheFile, $datas);
        }

        return json_decode($this->serializer->serialize($directions, 'json'), true);
    }

    /**
     * @param Maps           $map
     * @param Markers        $start
     * @param Markers        $end
     * @param TransportTypes $transportType
     *
     * @return array
     */
    protected function doGetDirections(Maps $map, Markers $start, Markers $end, TransportTypes $transportType = null)
    {

        /** @var MarkersRepository $repo */
        $repo = $this->entityManager->getRepository('EsterenMapsBundle:Markers');

        $allMarkers = $repo->getAllWithRoutesArray($map, $transportType);

        $allRoutes = array();

        $nodes = array();
        $edges = array();

        /**
         * Formatage des noeuds et des arcs pour une exploitation plus simple par l'algo de dijkstra
         */
        foreach ($allMarkers as $marker) {
            $markerId         = (int) $marker['id'];
            $nodes[$markerId] = array(
                'id'         => $markerId,
                'name'       => $marker['name'],
                'neighbours' => array(),
            );
            foreach ($marker['routesStart'] as $route) {
                $allRoutes[$route['id']]                  = $route;
                $routeId                                  = (int) $route['id'];
                $nodes[$markerId]['neighbours'][$routeId] = array(
                    'distance' => $route['distance'],
                    'end'      => $route['markerEnd']['id'],
                );
                if (!array_key_exists($routeId, $edges)) {
                    $edges[$routeId] = array(
                        'id'       => $routeId,
                        'name'     => $route['name'],
                        'distance' => $route['distance'],
                        'vertices' => array(
                            'start' => $markerId,
                            'end'   => $route['markerEnd']['id'],
                        ),
                    );
                }
            }
            foreach ($marker['routesEnd'] as $route) {
                $allRoutes[$route['id']]                  = $route;
                $routeId                                  = (int) $route['id'];
                $nodes[$markerId]['neighbours'][$routeId] = array(
                    'distance' => $route['distance'],
                    'end'      => $route['markerStart']['id'],
                );
                if (!array_key_exists($routeId, $edges)) {
                    $edges[$routeId] = array(
                        'id'       => $routeId,
                        'name'     => $route['name'],
                        'distance' => $route['distance'],
                        'vertices' => array(
                            'start' => $route['markerStart']['id'],
                            'end'   => $markerId,
                        ),
                    );
                }
            }
        }

        $paths = $this->dijkstra($nodes, $edges, (int) $start->getId(), (int) $end->getId());

        $steps = array();

        $allRoutes = $this->entityManager->getRepository('EsterenMapsBundle:Routes')->findByIdsArray(array_keys($allRoutes), true);

        foreach ($paths as $step) {
            $marker          = $allMarkers[$step['node']['id']];
            $marker['route'] = $allRoutes[$step['route']['id']];
            unset(
                $marker['routesStart'],
                $marker['routesEnd'],
                $marker['createdAt'],
                $marker['updatedAt'],
                $marker['deletedAt'],
                $marker['route']['createdAt'],
                $marker['route']['updatedAt'],
                $marker['route']['deletedAt'],
                $marker['route']['routeType']['createdAt'],
                $marker['route']['routeType']['updatedAt'],
                $marker['route']['routeType']['deletedAt']
            );
            $steps[] = $marker;
        }

        if (count($steps)) {
            // Ad the last marker
            /** @var Markers $end */
            $endMarker = $allMarkers[$end->getId()];
            unset($endMarker['routesStart'], $endMarker['routesEnd'], $endMarker['route']);
            $steps[] = $endMarker;
        }

        foreach ($steps as $k => $step) {
            unset($steps[$k]['route']['markerStart'], $steps[$k]['route']['markerEnd']);
        }

        $directions = $this->serializer->deserialize(json_encode($steps, 480), 'ArrayCollection<EsterenMaps\MapsBundle\Entity\Markers>', 'json') ?: array();

        return $this->getDataArray($start, $end, $directions);
    }

    /**
     * Applies Dijkstra algorithm to calculate minimal distance between source and target
     *
     * @param $nodes
     * @param $edges
     * @param $source
     * @param $target
     *
     * @return array
     */
    protected function dijkstra($nodes, $edges, $source, $target)
    {

        $distances = array();
        $previous  = array();

        foreach ($nodes as $id => $node) {
            $distances[$id] = INF;
            $previous[$id]  = null;
        }

        $distances[$source] = 0;

        $Q = $nodes;

        while (count($Q) > 0) {

            $min     = INF;
            $current = null;
            foreach ($Q as $id => $node) {
                if ($distances[$id] < $min) {
                    $min     = $distances[$id];
                    $current = $node;
                }
            }

            unset($Q[$current['id']]);
            if ($current['id'] === $target || !isset($distances[$current['id']]) || (isset($distances[$current['id']]) && $distances[$current['id']] == INF)) {
                break;
            }

            if (!empty($current['neighbours'])) {
                foreach ($current['neighbours'] as $route => $neighbour) {
                    $distance = $neighbour['distance'];
                    $end      = $neighbour['end'];
                    $alt      = $distances[$current['id']] + $distance;
                    if (!isset($distances[$end])) {
                        return array();
                    }
                    if ($alt < $distances[$end]) {
                        $distances[$end] = $alt;
                        $previous[$end]  = array(
                            'id'    => $current['id'],
                            'node'  => $current,
                            'route' => $edges[$route],
                        );
                    }
                }
            }

        }

        $path = array();
        $u    = array('id' => $target);
        while (isset($previous[$u['id']])) {
            array_unshift($path, $previous[$u['id']]);
            $u = $previous[$u['id']];
        }

        return $path;

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
        $hash = md5($map->getId().$start->getId().$end->getId().($transportType ? : ''));

        return $this->cacheDir.'/'.$hash.'.json';
    }

    /**
     * @param Markers   $from
     * @param Markers   $to
     * @param Markers[] $directions
     *
     * @return array
     */
    protected function getDataArray(Markers $from, Markers $to, array $directions)
    {
        $distance = 0;
        $NE       = array();
        $SW       = array();

        foreach ($directions as $step) {
            $distance += $step->route ? $step->route->getDistance() : 0;
            if ($step->route) {
                $coords = $step->route->getDecodedCoordinates();
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

        return array(
            'bounds'          => array(
                'northEast' => $NE,
                'southWest' => $SW,
            ),
            'total_distance'  => $distance,
            'number_of_steps' => count($directions) ? (count($directions) - 2) : 0,
            'start'           => $from,
            'end'             => $to,
            'path'            => $directions,
        );
    }
}
