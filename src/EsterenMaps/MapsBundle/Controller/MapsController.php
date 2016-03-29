<?php

namespace EsterenMaps\MapsBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class MapsController.
 *
 * @Route(host="%esteren_domains.esteren_maps%")
 */
class MapsController extends Controller
{
    /**
     * @Route("/map-{nameSlug}")
     * @Method("GET")
     */
    public function viewAction(Maps $map)
    {
        $tilesUrl = $this->generateUrl('esterenmaps_api_tiles', ['id' => 0, 'x' => 0, 'y' => 0, 'zoom' => 0], true);
        $tilesUrl = str_replace('0/0/0/0', '{id}/{z}/{x}/{y}', $tilesUrl);
        $tilesUrl = preg_replace('~app_dev\.php/~isUu', '', $tilesUrl);

        return $this->render('@EsterenMaps/Maps/view.html.twig', [
            'map'       => $map,
            'tilesUrl'  => $tilesUrl,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
        ]);
    }

    /**
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('@EsterenMaps/Maps/index.html.twig', [
            'list' => $this->getDoctrine()->getRepository('EsterenMapsBundle:Maps')->findAllRoot(),
        ]);
    }
}
