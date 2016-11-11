<?php

namespace Esteren\PortalBundle\Controller;

use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="portal_home", requirements={"_locale": "fr"})
     */
    public function indexAction()
    {
        return $this->render('@EsterenPortal/index-fr.html.twig');

    }
}
