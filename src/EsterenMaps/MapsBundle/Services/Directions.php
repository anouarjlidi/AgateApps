<?php

namespace EsterenMaps\MapsBundle\Services;

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Repository\MarkersRepository;
use JMS\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Directions
 * Utilise l'algorithme de Dijkstra pour calculer le trajet entre deux marqueurs
 * @package EsterenMaps\MapsBundle\Services
 */
class Directions {

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param EntityManager $entityManager
     * @param Serializer    $serializer
     */
    public function __construct(EntityManager $entityManager, Serializer $serializer) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @param Maps    $map
     * @param Markers $start
     * @param Markers $end
     * @return array
     */
    public function getDirectionByMarkers(Maps $map, Markers $start, Markers $end) {

        /** @var MarkersRepository $repo */
        $repo = $this->entityManager->getRepository('EsterenMapsBundle:Markers');

        $allMarkers = $repo->getAllWithRoutesArray($map);
        $allRoutes = array();

        $nodes = array();
        $edges = array();

        /**
         * Formatage des noeuds et des arcs pour une exploitation plus simple par l'algo de dijkstra
         */
        foreach ($allMarkers as $marker) {
            $markerId = (int) $marker['id'];
            $nodes[$markerId] = array(
                'id' => $markerId,
                'name' => $marker['name'],
                'neighbours' => array(),
            );
            foreach ($marker['routesStart'] as $route) {
                $allRoutes[$route['id']] = $route;
                $routeId = (int) $route['id'];
                $nodes[$markerId]['neighbours'][$routeId] = array(
                    'distance' => $route['distance'],
                    'end' => $route['markerEnd']['id'],
                );
                if (!array_key_exists($routeId, $edges)) {
                    $edges[$routeId] = array(
                        'id' => $routeId,
                        'name' => $route['name'],
                        'distance' => $route['distance'],
                        'vertices' => array(
                            'start' => $markerId,
                            'end' => $route['markerEnd']['id'],
                        ),
                    );
                }
            }
            foreach ($marker['routesEnd'] as $route) {
                $allRoutes[$route['id']] = $route;
                $routeId = (int) $route['id'];
                $nodes[$markerId]['neighbours'][$routeId] = array(
                    'distance' => $route['distance'],
                    'end' => $route['markerStart']['id'],
                );
                if (!array_key_exists($routeId, $edges)) {
                    $edges[$routeId] = array(
                        'id' => $routeId,
                        'name' => $route['name'],
                        'distance' => $route['distance'],
                        'vertices' => array(
                            'start' => $route['markerStart']['id'],
                            'end' => $markerId,
                        ),
                    );
                }
            }
        }

        $paths = $this->dijkstra($nodes, $edges, (int) $start->getId(), (int) $end->getId());

        $steps = array();

        foreach ($paths as $step) {
            $marker = $allMarkers[$step['node']['id']];
            $marker['route'] = $allRoutes[$step['route']['id']];
            unset($marker['routesStart'], $marker['routesEnd']);
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

        $json = json_encode($steps);

        return $this->serializer->deserialize($json, 'ArrayCollection<EsterenMaps\MapsBundle\Entity\Markers>', 'json');
    }

    /**
     * Applies Dijkstra algorithm to calculate minimal distance between source and target
     * @param $nodes
     * @param $edges
     * @param $source
     * @param $target
     * @return array
     */
    public function dijkstra($nodes, $edges, $source, $target) {

        $distances = array();
        $previous = array();

        foreach ($nodes as $id => $node) {
            $distances[$id] = INF;
            $previous[$id] = null;
        }

        $distances[$source] = 0;

        $Q = $nodes;

        while (count($Q) > 0) {

            $min = INF;
            $current = null;
            foreach ($Q as $id => $node){
                if ($distances[$id] < $min) {
                    $min = $distances[$id];
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
                    $end = $neighbour['end'];
                    $alt = $distances[$current['id']] + $distance;
                    if ($alt < $distances[$end]) {
                        $distances[$end] = $alt;
                        $previous[$end] = array(
                            'id' => $current['id'],
                            'node' => $current,
                            'route' => $edges[$route],
                        );
                    }
                }
            }

        }

        $path = array();
        $u = array('id'=>$target);
        while (isset($previous[$u['id']])) {
            array_unshift($path, $previous[$u['id']]);
            $u = $previous[$u['id']];
        }

        return $path;

    }
}
