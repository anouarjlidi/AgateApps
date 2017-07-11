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

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @Cache(expires="+1 hour")
 * @Route(host="%esteren_domains.api%")
 */
class MapsController extends Controller
{
    /**
     * @Route("/maps/{id}", name="esterenmaps_api_maps_get", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function getAction($id)
    {
        return new JsonResponse($this->get('esterenmaps.api.map')->getMap($id));
    }

    /**
     * @Route("/maps/settings/{id}.{_format}",
     *     requirements={"id": "\d+", "_format": "json"},
     *     defaults={"_format": "json"},
     *     name="esterenmaps_api_maps_settings_distant"
     * )
     * @Method("GET")
     * @Cache(maxage=3600, expires="+1 hour", public=true)
     */
    public function settingsAction(Maps $map, Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }

        $data = [];

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $markersTypes = $em->getRepository('EsterenMapsBundle:MarkersTypes')->findBy([], ['name' => 'asc']);
        $zonesTypes   = $em->getRepository('EsterenMapsBundle:ZonesTypes')->findBy([], ['name' => 'asc']);
        $routesTypes  = $em->getRepository('EsterenMapsBundle:RoutesTypes')->findBy([], ['name' => 'asc']);
        $factions     = $em->getRepository('EsterenMapsBundle:Factions')->findBy([], ['name' => 'asc']);

        if ($request->query->get('editMode') === 'true') {
            $data['LeafletPopupMarkerBaseContent'] = $this->renderView('@EsterenMaps/Api/popupContentMarkerEditMode.html.twig', [
                'markersTypes' => $markersTypes,
                'factions'     => $factions,
            ]);
            $data['LeafletPopupPolylineBaseContent'] = $this->renderView('@EsterenMaps/Api/popupContentPolylineEditMode.html.twig', [
                'markers'     => $map->getMarkers(),
                'routesTypes' => $routesTypes,
                'factions'    => $factions,
            ]);
            $data['LeafletPopupPolygonBaseContent'] = $this->renderView('@EsterenMaps/Api/popupContentPolygonEditMode.html.twig', [
                'factions'   => $factions,
                'zonesTypes' => $zonesTypes,
            ]);
        } else {
            $data['LeafletPopupMarkerBaseContent'] = $this->renderView('@EsterenMaps/Api/popupContentMarker.html.twig', [
                'markersTypes' => $markersTypes,
                'factions'     => $factions,
            ]);
            $data['LeafletPopupPolylineBaseContent'] = $this->renderView('@EsterenMaps/Api/popupContentPolyline.html.twig', [
                'markers'     => $map->getMarkers(),
                'routesTypes' => $routesTypes,
                'factions'    => $factions,
            ]);
            $data['LeafletPopupPolygonBaseContent'] = $this->renderView('@EsterenMaps/Api/popupContentPolygon.html.twig', [
                'factions'   => $factions,
                'zonesTypes' => $zonesTypes,
            ]);
        }

        $response = new Response();
        $data     = json_encode(['settings' => $data], 335);

        $response->headers->add(['Content-type' => 'application/json; charset=utf-8']);

        $response->setContent($data);

        return $response;
    }

    /**
     * @Route("/maps/ref-data", host="%esteren_domains.api%", name="esterenmaps_api_maps_filters_distant")
     * @Method("GET")
     * @Cache(maxage=3600, expires="+1 hour", public=true)
     */
    public function mapRefDataAction(Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }

        $em = $this->getDoctrine()->getManager();

        $data = $this->get('jms_serializer')->serialize([
            'ref-data' => [
                'markersTypes' => $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAll(true),
                'routesTypes'  => $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAll(true),
                'zonesTypes'   => $em->getRepository('EsterenMapsBundle:ZonesTypes')->findAll(true),
                'factions'     => $em->getRepository('EsterenMapsBundle:Factions')->findAll(true),
            ],
        ], 'json')
        ;

        $response = new Response($data, 200, ['Content-type' => 'application/json; charset=utf-8']);

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return false|Response
     *
     * @throws AccessDeniedException
     */
    private function checkAsker(Request $request)
    {
        try {
            $this->container->get('pierstoval.api.origin_checker')->checkRequest($request);

            return false;
        } catch (AccessDeniedException $e) {
            return new Response($e->getMessage(), 403);
        }
    }
}
