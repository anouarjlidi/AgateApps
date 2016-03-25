<?php

namespace EsterenMaps\ApiBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use EsterenMaps\MapsBundle\Entity\Maps;

class MapsController extends Controller
{
    /**
     * @Route("/maps/settings/{id}.{_format}",
     *      requirements={"id":"\d+","_format":"json"},
     *      defaults={"_format":"json"}, host="%esteren_domains.api%",
     *      name="esterenmaps_api_maps_settings_distant"
     * )
     * @Method("GET")
     */
    public function settingsAction(Maps $map, Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }

        $datas = [];

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $markersTypes = $em->getRepository('EsterenMapsBundle:MarkersTypes')->findBy([], ['name' => 'asc']);
        $zonesTypes = $em->getRepository('EsterenMapsBundle:ZonesTypes')->findBy([], ['name' => 'asc']);
        $routesTypes = $em->getRepository('EsterenMapsBundle:RoutesTypes')->findBy([], ['name' => 'asc']);
        $factions = $em->getRepository('EsterenMapsBundle:Factions')->findBy([], ['name' => 'asc']);

        if ($request->query->get('editMode') === 'true') {
            $datas['LeafletPopupMarkerBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentMarkerEditMode.html.twig', [
                'markersTypes' => $markersTypes,
                'factions' => $factions,
            ]);
            $datas['LeafletPopupPolylineBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolylineEditMode.html.twig', [
                'markers' => $map->getMarkers(),
                'routesTypes' => $routesTypes,
                'factions' => $factions,
            ]);
            $datas['LeafletPopupPolygonBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolygonEditMode.html.twig', [
                'factions' => $factions,
                'zonesTypes' => $zonesTypes,
            ]);
        } else {
            $datas['LeafletPopupMarkerBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentMarker.html.twig', [
                'markersTypes' => $markersTypes,
                'factions' => $factions,
            ]);
            $datas['LeafletPopupPolylineBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolyline.html.twig', [
                'markers' => $map->getMarkers(),
                'routesTypes' => $routesTypes,
                'factions' => $factions,
            ]);
            $datas['LeafletPopupPolygonBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolygon.html.twig', [
                'factions' => $factions,
                'zonesTypes' => $zonesTypes,
            ]);
        }

        $response = new Response();
        $datas = json_encode(['settings' => $datas], 335);

        $response->headers->add(['Content-type' => 'application/json; charset=utf-8']);

        $response->setContent($datas);

        return $response;
    }

    /**
     * @Route("/maps/ref-datas", host="%esteren_domains.api%",
     *                           name="esterenmaps_api_maps_filters_distant")
     * @Method("GET")
     */
    public function mapRefDatasAction(Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }

        $em = $this->getDoctrine()->getManager();

        $datas = $this->get('jms_serializer')->serialize([
            'ref-datas' => [
                'markersTypes' => $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAll(true),
                'routesTypes' => $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAll(true),
                'zonesTypes' => $em->getRepository('EsterenMapsBundle:ZonesTypes')->findAll(true),
                'factions' => $em->getRepository('EsterenMapsBundle:Factions')->findAll(true),
            ],
        ], 'json');

        $response = new Response($datas, 200, ['Content-type' => 'application/json; charset=utf-8']);

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
            $this->container->get('pierstoval.api.originChecker')->checkRequest($request);

            return false;
        } catch (AccessDeniedException $e) {
            return new Response($e->getMessage(), 403);
        }
    }
}
