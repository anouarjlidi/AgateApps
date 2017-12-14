<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\Controller;

use EsterenMaps\Entity\Maps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("has_role('ROLE_MANAGER')")
 * @Route(host="%esteren_domains.backoffice%")
 */
class AdminMapsController extends AbstractController
{
    private $tileSize;

    public function __construct(string $tileSize)
    {
        $this->tileSize = $tileSize;
    }

    /**
     * @Route("/maps/edit-interactive/{id}", name="admin_esterenmaps_maps_maps_editInteractive", methods={"GET"})
     */
    public function editAction(Maps $map): Response
    {
        return $this->render('esteren_maps/AdminMaps/edit.html.twig', [
            'map'       => $map,
            'tile_size' => $this->tileSize,
        ]);
    }
}
