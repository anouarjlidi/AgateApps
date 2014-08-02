<?php

namespace EsterenMaps\MapsBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DirectionsController extends Controller {

    /**
     * @Route("/api/maps/directions/{id}/{from}/{to}", requirements={"id":"\d+", "from":"\d+", "to":"\d+"})
     * @Cache(public=true, maxage=3600)
     */
    public function getDirectionsAction(Maps $map, $from, $to) {

        $hash = md5($map->getId().$from.$to);
        $cacheDir = $this->container->getParameter('kernel.cache_dir').'/esterenmaps/directions';
        $cachedFile = $cacheDir.'/'.$hash.'.json';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        $serializer = $this->container->get('jms_serializer');

        // Cache lifetime of 1h for routing system
        $exists = file_exists($cachedFile) && filemtime($cachedFile) > (time() - 3600);

        if ($exists) {
            $serialized = file_get_contents($cachedFile);
        } else {
            $repo = $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Markers');
            $markerStart = $repo->find($from);
            $markerEnd = $repo->find($to);

            $directions = $this->container->get('esterenmaps.directions')->getDirectionByMarkers($map, $markerStart, $markerEnd);
            $serialized = $serializer->serialize($directions, 'json');
            file_put_contents($cachedFile, $serialized);
        }

        return new Response($serialized, 200, array('Content-Type'=>'application/json'));
    }

} 