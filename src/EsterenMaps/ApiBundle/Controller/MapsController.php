<?php

namespace EsterenMaps\ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use EsterenMaps\MapsBundle\Entity\Maps;

class MapsController extends Controller
{

    private $img_size = 0;

    /**
     * @Route("/api/maps/settings/{id}", requirements={"id":"\d+"}, host="%esteren_domains.esteren_maps%", name="esterenmaps_api_maps_settings_local")
     * @Route("/maps/settings/{id}.{_format}", requirements={"id":"\d+","_format":"js|json"}, defaults={"_format":"json"}, host="%esteren_domains.api%", name="esterenmaps_api_maps_settings_distant")
     * @Method("GET")
     */
    public function settingsAction(Maps $map, Request $request, $_format) {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }

        $datas = array();

        $get = $request->query;

        $em = $this->getDoctrine()->getManager();

        $markersTypes = $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAll();
        $zonesTypes = $em->getRepository('EsterenMapsBundle:ZonesTypes')->findAll();
        $routesTypes = $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAll();
        $factions = $em->getRepository('EsterenMapsBundle:Factions')->findAll();

        if ($get->get('editMode') === 'true') {
            $datas['LeafletPopupMarkerBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentMarkerEditMode.html.twig',array('markersTypes'=>$markersTypes,'factions'=>$factions));
            $datas['LeafletPopupPolylineBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolylineEditMode.html.twig', array('markers'=>$map->getMarkers(),'routesTypes'=>$routesTypes,'factions'=>$factions));
            $datas['LeafletPopupPolygonBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolygonEditMode.html.twig',array('factions'=>$factions, 'zonesTypes'=>$zonesTypes));
        } else {
            $datas['LeafletPopupMarkerBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentMarker.html.twig',array('markersTypes'=>$markersTypes,'factions'=>$factions));
            $datas['LeafletPopupPolylineBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolyline.html.twig', array('markers'=>$map->getMarkers(),'routesTypes'=>$routesTypes,'factions'=>$factions));
            $datas['LeafletPopupPolygonBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolygon.html.twig',array('factions'=>$factions, 'zonesTypes'=>$zonesTypes));
        }

        $response = new Response();
        $datas = json_encode(array('settings'=>$datas), 335);

        if ($_format === 'json') {
            $response->headers->add(array('Content-type' => 'application/json; charset=utf-8',));
        } elseif ($_format === 'js') {
            $response->headers->add(array('Content-type' => 'text/javascript; charset=utf-8',));
            $datas = 'EsterenMap.prototype.settings = '.$datas.';';
        }

        $response->setContent($datas);

        return $response;
    }

    /**
     * @Route("/api/maps/ref-datas", host="%esteren_domains.esteren_maps%", name="esterenmaps_api_maps_filters_local")
     * @Route("/maps/ref-datas", host="%esteren_domains.api%", name="esterenmaps_api_maps_filters_distant")
     * @Method("GET")
     */
    public function mapRefDatasAction(Request $request)
    {
        if ($check = $this->checkAsker($request)) {
            return $check;
        }

        $serializer = $this->get('jms_serializer');

        $em = $this->getDoctrine()->getManager();

        $datas = array(
            'markersTypes' => $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAll(true),
            'routesTypes' => $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAll(true),
            'zonesTypes' => $em->getRepository('EsterenMapsBundle:ZonesTypes')->findAll(true),
            'factions' => $em->getRepository('CorahnRinModelsBundle:Factions')->findAll(true),
        );

        $response = new Response();
        $datas = $serializer->serialize(array('ref-datas' => $datas), 'json');

        $response->headers->add(array('Content-type' => 'application/json; charset=utf-8',));

        $response->setContent($datas);

        return $response;
    }

    /*--------------------------------------------------
    ----------------- MÉTHODES PRIVÉES -----------------
    --------------------------------------------------*/

    /**
     * @param Request $request
     * @return false|Response
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
