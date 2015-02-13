<?php

namespace EsterenMaps\AdminBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Factions;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\MarkersTypes;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use EsterenMaps\MapsBundle\Entity\Zones;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminMapsController extends Controller {

    /** @var MarkersTypes[] */
    private $markersTypes;

    /** @var RoutesTypes[] */
    private $routesTypes;

    /** @var Factions[] */
    private $factions;

    /**
     * @Route("/maps/edit-interactive/{id}", name="admin_esterenmaps_maps_maps_editInteractive")
     * @Template()
     * @param Maps $map
     * @param Request $request
     * @return array
     */
    public function editAction(Maps $map, Request $request) {

        $this->denyAccessUnlessGranted('ROLE_MANAGER');

        $em = $this->getDoctrine()->getManager();

        $routesTypes = $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAll(true);
        $markersTypes = $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAll(true);
        $factions = $em->getRepository('EsterenMapsBundle:Factions')->findAll(true);

        $this->routesTypes = $routesTypes;
        $this->markersTypes = $markersTypes;
        $this->factions = $factions;

        $tilesUrl = $this->generateUrl('esterenmaps_api_tiles_tile_distant', array('id'=>0,'x'=>0,'y'=>0,'zoom'=>0), true);
        $tilesUrl = str_replace('0/0/0/0','{id}/{z}/{x}/{y}', $tilesUrl);
        $tilesUrl = preg_replace('~app_dev(_fast)\.php/~isUu', '', $tilesUrl);

        return array(
            'config' => $this->container->getParameter('easy_admin.config'),
            'map' => $map,
            'tilesUrl' => $tilesUrl,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
            'routesTypes' => $routesTypes,
            'markersTypes' => $markersTypes,
            'factions' => $factions,
        );
    }

}
