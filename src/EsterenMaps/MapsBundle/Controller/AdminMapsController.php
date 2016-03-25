<?php

namespace EsterenMaps\MapsBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Security("has_role('ROLE_MANAGER')")
 * @Route(host="%esteren_domains.backoffice%")
 */
class AdminMapsController extends Controller
{
    /**
     * @Route("/maps/edit-interactive/{id}", name="admin_esterenmaps_maps_maps_editInteractive")
     *
     * @param Maps $map
     *
     * @return array
     */
    public function editAction(Maps $map)
    {
        return $this->render('@EsterenMaps/AdminMaps/edit.html.twig', array(
            'config' => $this->container->getParameter('easyadmin.config'),
            'map' => $map,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
        ));
    }
}
