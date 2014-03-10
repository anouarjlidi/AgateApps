<?php

namespace CorahnRin\MapsBundle\Controller;

use CorahnRin\MapsBundle\Entity\Maps;

use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ApiMapsController extends FOSRestController {

    /**
     * @Rest\View()
     */
    public function cgetAction() {
        $repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps');

        $maps = $repo->findAll();
        if (!$maps) {
            throw $this->createNotFoundException('No map found');
        }
        return array('maps'=>$maps);
    }

    /**
     * @Rest\View()
     */
    public function getAction($id) {
        $repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps');

        $map = $repo->find($id);
        if (!$map) {
            throw $this->createNotFoundException('Incorrect ID : No map found.');
        }
        return array('map'=>$map);
    }

    /**
     * @Route("/api/maps/init/", defaults={"_format":"json"})
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
        $map = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findOneBy(array('id'=>$id));

        if (!$map) {
            return $this->quit('Aucune carte trouvée', 404);
        }

        $route_tiles = urldecode($this->generateUrl('corahnrin_maps_api_tile', array('zoom'=>'{zoom}','id'=>$map->getId(), 'x'=>'{x}','y'=>'{y}')));

        $img_size = $this->container->getParameter('corahn_rin_maps.tile_size');
        $tilesManager = new MapsTileManager($map, $img_size);

        $identifications = array();
        for ($i = 1; $i <= $map->getMaxZoom(); $i++) {
            $identifications[$i] = $tilesManager->identifyImage($i);
        }

        $datas = array(
            'id' => $map->getId(),
            'name' => $map->getName(),
            'nameSlug' => $map->getNameSlug(),
            'identifications' => $identifications,
            'maxZoom' => $map->getMaxZoom(),
            'imgSize' => $img_size,
            'tilesUrl' => str_replace('{id}', $map->getId(), $route_tiles),
        );

        $response->setContent(json_encode($datas, P_JSON_ENCODE));

        //Envoi des données au navigateur;
        return $response;
    }
    */

}
