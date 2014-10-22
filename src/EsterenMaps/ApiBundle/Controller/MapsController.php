<?php

namespace EsterenMaps\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use EsterenMaps\MapsBundle\Entity\Maps;

class MapsController extends Controller
{

    private $img_size = 0;

    /**
     * @Route("/api/maps/settings/{id}", requirements={"id":"\d+"}, host="%esteren_domains.esteren_maps%", name="esterenmaps_api_maps_settings_local")
     * @Route("/maps/settings/{id}", requirements={"id":"\d+"}, host="%esteren_domains.api%", name="esterenmaps_api_maps_settings_distant")
     */
    public function settingsAction(Maps $map, Request $request) {
        $this->container->get('pierstoval.api.originChecker')->checkRequest($request);

        $datas = array();

        $post = $request->request;

        $em = $this->getDoctrine()->getManager();

        $markersTypes = $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAll();
        $zonesTypes = $em->getRepository('EsterenMapsBundle:ZonesTypes')->findAll();
        $routesTypes = $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAll();
        $factions = $em->getRepository('EsterenMapsBundle:Factions')->findAll();

        if ($post->get('editMode') == true) {
            $datas['LeafletPopupMarkerBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentMarkerEditMode.html.twig',array('markersTypes'=>$markersTypes,'factions'=>$factions));
            $datas['LeafletPopupPolylineBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolylineEditMode.html.twig', array('markers'=>$map->getMarkers(),'routesTypes'=>$routesTypes,'factions'=>$factions));
            $datas['LeafletPopupPolygonBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolygonEditMode.html.twig',array('factions'=>$factions, 'zonesTypes'=>$zonesTypes));
        } else {
            $datas['LeafletPopupMarkerBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentMarker.html.twig',array('markersTypes'=>$markersTypes,'factions'=>$factions));
            $datas['LeafletPopupPolylineBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolyline.html.twig', array('markers'=>$map->getMarkers(),'routesTypes'=>$routesTypes,'factions'=>$factions));
            $datas['LeafletPopupPolygonBaseContent'] = $this->renderView('EsterenMapsApiBundle:Maps:popupContentPolygon.html.twig',array('factions'=>$factions, 'zonesTypes'=>$zonesTypes));
        }

        $datas = json_encode(array('settings'=>$datas), 480);

        $response = new Response();

        $response->headers->add(array('Content-type' => 'application/json; charset=utf-8',));

        if ($request->headers->has('Origin')) {
            // Corrige les erreurs liées à AJAX et aux requêtes Cross-Origin
//            $response->headers->set('Access-Control-Allow-Origin', $request->headers->get('Origin'));
        }

        $response->setContent($datas);

        return $response;
    }


}
