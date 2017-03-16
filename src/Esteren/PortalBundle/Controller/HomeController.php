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

class HomeController extends Controller
{
    /**
     * @Route("/", name="portal_home")
     */
    public function indexAction($_locale)
    {
        $template = '@EsterenPortal/index-'.$_locale.'.html.twig';

        if (!$this->get('templating')->exists($template)) {
            throw $this->createNotFoundException();
        }

        return $this->render($template);
    }
}
