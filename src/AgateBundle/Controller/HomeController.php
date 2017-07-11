<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AgateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route(host="%agate_domains.portal%")
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="agate_portal_home")
     */
    public function indexAction($_locale)
    {
        $template = '@Agate/home/index-'.$_locale.'.html.twig';

        if (!$this->get('templating')->exists($template)) {
            throw $this->createNotFoundException();
        }

        return $this->render($template);
    }

    /**
     * @Route("/team", name="agate_team")
     */
    public function teamAction()
    {
        return $this->render('@Agate/home/team.html.twig');
    }
}
