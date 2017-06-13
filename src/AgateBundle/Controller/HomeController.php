<?php

namespace AgateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="agate_portal_home")
     */
    public function indexAction()
    {
        return $this->render('@Agate/home/agate-portal.html.twig');
    }

    /**
     * @Route("/team", name="agate_team")
     */
    public function teamAction()
    {
        return $this->render('@Agate/home/team.html.twig');
    }
}
