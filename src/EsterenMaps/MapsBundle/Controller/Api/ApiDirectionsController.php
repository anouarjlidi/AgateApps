<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Controller\Api;

use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiDirectionsController extends Controller
{
    /**
     * @Route("/maps/directions/{id}/{from}/{to}",
     *     name="esterenmaps_directions",
     *     requirements={"id": "\d+", "from": "\d+", "to": "\d+"},
     *     methods={"GET"}
     * )
     * @ParamConverter(name="from", class="EsterenMapsBundle:Markers", options={"id": "from"})
     * @ParamConverter(name="to", class="EsterenMapsBundle:Markers", options={"id": "to"})
     *
     * @param Maps    $map
     * @param Markers $from
     * @param Markers $to
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getDirectionsAction(Maps $map, Markers $from, Markers $to, Request $request)
    {
        $code = 200;

        $transportId = $request->query->get('transport');
        $transport   = $this->getDoctrine()->getRepository(TransportTypes::class)->findOneBy(['id' => $transportId]);

        $hoursPerDay = $request->query->get('hours_per_day', 7);

        if (!$transport && $transportId) {
            $output = $this->getError($from, $to, $transportId, 'Transport not found.');
            $code   = 404;
        } else {
            $output = $this->get('esterenmaps')->getDirectionsManager()->getDirections($map, $from, $to, $hoursPerDay, $transport);
            if (!count($output)) {
                $output = $this->getError($from, $to);
                $code   = 404;
            }
        }

        $response = new JsonResponse($output, $code);

        $response->setCache([
            'etag' => sha1('js'.$map->getId().$from->getId().$to->getId().$transportId.$this->getParameter('version_code')),
            'last_modified' => new \DateTime($this->getParameter('version_date')),
            'max_age' => 600,
            's_maxage' => 600,
            'public' => true,
        ]);

        return $response;
    }

    /**
     * @param Markers $from
     * @param Markers $to
     * @param int     $transportId
     * @param string  $message
     *
     * @return array
     */
    private function getError(Markers $from, Markers $to, $transportId = null, $message = 'No path found for this query.')
    {
        return [
            'error'   => true,
            'message' => $this->get('translator')->trans($message),
            'query'   => [
                'from'      => $from,
                'to'        => $to,
                'transport' => $transportId,
            ],
        ];
    }
}
