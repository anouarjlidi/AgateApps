<?php

namespace EsterenMaps\ApiBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DirectionsController extends Controller {

    /**
     * @Route("/maps/directions/{id}/{from}/{to}", name="esterenmaps_directions", requirements={"id":"\d+", "from":"\d+", "to":"\d+"}, host="%esteren_domains.api%")
     * @ParamConverter(name="from", class="EsterenMapsBundle:Markers", options={"id": "from"})
     * @ParamConverter(name="to", class="EsterenMapsBundle:Markers", options={"id": "to"})
     * @-Cache(public=true, maxage=3600)
     */
    public function getDirectionsAction(Maps $map, Markers $from, Markers $to, Request $request) {

        $this->container->get('pierstoval.api.originChecker')->checkRequest($request);
        $serializer = $this->container->get('jms_serializer');
        $cachedFile = $this->getCacheFile($map, $from, $to);

        // Cache lifetime of 1h for routing system
        $exists = file_exists($cachedFile) && filemtime($cachedFile) > (time() - 3600);

        if (true === $exists && $this->get('kernel')->getEnvironment() !== 'dev'/** TODO : To remove when feature ready */) {
            $serialized = file_get_contents($cachedFile);
        } else {
            $directions = $this->container->get('esterenmaps.directions')->getDirectionByMarkers($map, $from, $to);
            if (count($directions)) {
                $serialized = $serializer->serialize($this->getDataArray($from, $to, $directions), 'json');
            } else {
                $serialized = $serializer->serialize($this->getError($from, $to), 'json');
            }
            file_put_contents($cachedFile, $serialized);
        }

        return new Response($serialized, 200, array('Content-Type'=>'application/json'));
    }

    /**
     * @param Markers $from
     * @param Markers $to
     * @param Markers[] $directions
     * @return array
     */
    private function getDataArray(Markers $from, Markers $to, array $directions)
    {
        $distance = 0;
        $NE = array();
        $SW = array();

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
            'bounds' => array(
                'northEast' => $NE,
                'southWest' => $SW,
            ),
            'total_distance' => $distance,
            'path' => $directions,
            'number_of_steps' => count($directions) - 2,
            'start' => $from,
            'end' => $to,
        );
    }

    /**
     * @param Markers $from
     * @param Markers $to
     * @return array
     */
    private function getError(Markers $from, Markers $to)
    {
        return array(
            'error' => true,
            'message' => $this->get('translator')->trans('No path found for this query.'),
            'query' => array(
                'from' => $from,
                'to' => $to,
            ),
        );
    }

    /**
     * @param Maps $map
     * @param Markers $from
     * @param Markers $to
     * @return string
     */
    private function getCacheFile(Maps $map, Markers $from, Markers $to)
    {
        $hash = md5($map->getId().$from.$to);
        $cacheDir = $this->container->getParameter('kernel.cache_dir').'/esterenmaps/directions';
        $cachedFile = $cacheDir.'/'.$hash.'.json';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }
        return $cachedFile;
    }
}
