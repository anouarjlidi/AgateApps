<?php

namespace EsterenMaps\MapsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @Template()
     */
    public function viewAction(Maps $map) {

        $tilesUrl = $this->generateUrl('esterenmaps_api_tiles_tile_distant', array('id'=>0,'x'=>0,'y'=>0,'zoom'=>0), true);
        $tilesUrl = str_replace('0/0/0/0','{id}/{z}/{x}/{y}', $tilesUrl);
        $tilesUrl = preg_replace('~app_dev(_fast)?\.php/~isUu', '', $tilesUrl);

        return array(
            'map' => $map,
            'tilesUrl' => $tilesUrl,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
        );
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction() {
        $list = $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Maps')->findAll();
        return array('list' => $list);
    }

}
