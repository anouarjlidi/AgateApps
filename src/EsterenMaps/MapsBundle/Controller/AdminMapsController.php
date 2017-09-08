<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("has_role('ROLE_MANAGER')")
 * @Route(host="%esteren_domains.backoffice%")
 */
class AdminMapsController extends Controller
{
    /**
     * @Route("/maps/edit-interactive/{id}", name="admin_esterenmaps_maps_maps_editInteractive")
     */
    public function editAction(Maps $map): Response
    {
        return $this->render('@EsterenMaps/AdminMaps/edit.html.twig', [
            'config'    => $this->container->getParameter('easyadmin.config'),
            'map'       => $map,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
        ]);
    }
}
