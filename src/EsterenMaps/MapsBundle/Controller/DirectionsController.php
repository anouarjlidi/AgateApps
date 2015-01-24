<?php

namespace EsterenMaps\MapsBundle\Controller;

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
     * @Cache(public=true, maxage=3600)
     */
    public function getDirectionsAction(Maps $map, Markers $from, Markers $to, Request $request) {

        $this->container->get('pierstoval.api.originChecker')->checkRequest($request);

        $hash = md5($map->getId().$from.$to);
        $cacheDir = $this->container->getParameter('kernel.cache_dir').'/esterenmaps/directions';
        $cachedFile = $cacheDir.'/'.$hash.'.json';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        $serializer = $this->container->get('jms_serializer');

        // Cache lifetime of 1h for routing system
        $exists = file_exists($cachedFile) && filemtime($cachedFile) > (time() - 3600);

        if (true === $exists && $this->get('kernel')->getEnvironment() !== 'dev') {
            $serialized = file_get_contents($cachedFile);
        } else {
            $directions = $this->container->get('esterenmaps.directions')->getDirectionByMarkers($map, $from, $to);
            if (count($directions)) {
                $serialized = $serializer->serialize($directions, 'json');
            } else {
                $serialized = $serializer->serialize(array(
                    'error' => true,
                    'message' => $this->get('translator')->trans('No path found for this query.'),
                    'query' => array(
                        'from' => $from,
                        'to' => $to,
                    ),
                ), 'json');
            }
            file_put_contents($cachedFile, $serialized);
        }

        return new Response($serialized, 200, array('Content-Type'=>'application/json'));
    }

} 