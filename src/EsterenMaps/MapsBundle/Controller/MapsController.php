<?php

namespace EsterenMaps\MapsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use EsterenMaps\MapsBundle\Entity\Maps;

/**
 * Class MapsController
 * @package EsterenMaps\MapsBundle\Controller
 * @Route(host="%esteren_domains.esteren_maps%")
 */
class MapsController extends Controller
{

    /**
     * @Route("/map-{nameSlug}")
     * @Method("GET")
     */
    public function viewAction(Maps $map) {

        $tilesUrl = $this->generateUrl('esterenmaps_api_tiles', array('id'=>0,'x'=>0,'y'=>0,'zoom'=>0), true);
        $tilesUrl = str_replace('0/0/0/0','{id}/{z}/{x}/{y}', $tilesUrl);
        $tilesUrl = preg_replace('~app_dev\.php/~isUu', '', $tilesUrl);

        return $this->render('@EsterenMaps/Maps/view.html.twig', array(
            'map' => $map,
            'tilesUrl' => $tilesUrl,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
        ));
    }

    /**
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction() {
        $list = $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Maps')->findAllRoot();
        return $this->render('@EsterenMaps/Maps/index.html.twig', array('list' => $list));
    }

}
