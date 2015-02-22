<?php

namespace EsterenMaps\AdminBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_MANAGER')")
 */
class AdminMapsController extends Controller {

    /**
     * @Route("/maps/edit-interactive/{id}", name="admin_esterenmaps_maps_maps_editInteractive")
     * @Template()
     * @param Maps $map
     * @param Request $request
     * @return array
     */
    public function editAction(Maps $map, Request $request) {

        $request->query->set('entity', 'Maps');

        return array(
            'config' => $this->container->getParameter('easyadmin.config'),
            'map' => $map,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
        );
    }

}
