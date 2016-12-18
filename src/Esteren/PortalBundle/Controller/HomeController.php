<?php

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
