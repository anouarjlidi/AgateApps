<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esteren\PortalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FeondBeerController extends Controller
{
    /**
     * @Route("/feond-beer", name="esteren_portal_feond_beer")
     */
    public function feondBeerPortalAction()
    {
        return $this->render('@EsterenPortal/feond_beer.html.twig');
    }
}
