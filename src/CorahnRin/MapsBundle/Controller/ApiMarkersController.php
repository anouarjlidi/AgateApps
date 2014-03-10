<?php

namespace CorahnRin\MapsBundle\Controller;

use CorahnRin\MapsBundle\Entity\Markers;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiMarkersController extends FOSRestController {

    /**
     * @Rest\View()
     */
    public function cgetAction() {
        $repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Markers');

        $markers = $repo->findAll();
        if (!$markers) {
            throw $this->createNotFoundException('No marker found');
        }
        return array('markers'=>$markers);
    }

    /**
     * @Rest\View()
     */
    public function getAction($id) {
        $repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Markers');

        $marker = $repo->find($id);
        if (!$marker) {
            throw $this->createNotFoundException('Incorrect ID : No marker found.');
        }
        return array('marker'=>$marker);
    }

    /**
     * @Route("/api/markers/init/", defaults={"_format":"json"})
     * @Method({"POST"})
     */
    /*
    public function initAction() {
        $this->init();

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-type','application/json');

        $id = $this->getRequest()->request->get('id');
        if (!$id) {
            return $this->quit('Un identifiant doit être indiqué');
        }
        $marker = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Markers')->findOneBy(array('id'=>$id));

        if (!$marker) {
            return $this->quit('Aucune carte trouvée', 404);
        }

        $route_tiles = urldecode($this->generateUrl('corahnrin_markers_api_tile', array('zoom'=>'{zoom}','id'=>$marker->getId(), 'x'=>'{x}','y'=>'{y}')));

        $img_size = $this->container->getParameter('corahn_rin_markers.tile_size');
        $tilesManager = new MarkersTileManager($marker, $img_size);

        $identifications = array();
        for ($i = 1; $i <= $marker->getMaxZoom(); $i++) {
            $identifications[$i] = $tilesManager->identifyImage($i);
        }

        $datas = array(
            'id' => $marker->getId(),
            'name' => $marker->getName(),
            'nameSlug' => $marker->getNameSlug(),
            'identifications' => $identifications,
            'maxZoom' => $marker->getMaxZoom(),
            'imgSize' => $img_size,
            'tilesUrl' => str_replace('{id}', $marker->getId(), $route_tiles),
        );

        $response->setContent(json_encode($datas, P_JSON_ENCODE));

        //Envoi des données au navigateur;
        return $response;
    }
    */

}
