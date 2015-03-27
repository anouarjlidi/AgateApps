<?php

namespace EsterenMaps\ApiBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $code = 200;

        $transportId = $request->query->get('transport');
        $transport = $this->getDoctrine()->getRepository('EsterenMapsBundle:TransportTypes')->findOneBy(array('id' => $transportId));
        if (!$transport && $transportId) {
            $directions = $this->getError($from, $to, $transportId, 'Transport not found.');
            $code = 404;
        } else {
            $directions = $this->container->get('esterenmaps.directions')->getDirections($map, $from, $to, $transport);
            if (!count($directions)) {
                $directions = $this->getError($from, $to);
                $code = 404;
            }
        }

        return new JsonResponse($directions, $code);
    }

    /**
     * @param Markers $from
     * @param Markers $to
     * @param string $message
     * @return array
     */
    private function getError(Markers $from, Markers $to, $transportId = null, $message = 'No path found for this query.')
    {
        return array(
            'error' => true,
            'message' => $this->get('translator')->trans($message),
            'query' => array(
                'from' => $from,
                'to' => $to,
                'transport' => $transportId,
            ),
        );
    }
}
