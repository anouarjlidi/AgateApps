<?php

namespace Pierstoval\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Route("/old/")
     * @Template("PierstovalAdminBundle:Admin:layout.html.twig")
     */
    public function indexAction() {
        $controller = '';
        $params = array();
        return array(
            'controller' => $controller,
            '_params' => $params,
        );
    }

	/**
	 * @Template()
	 */
	public function menuAction($route) {

        $links = $this->getDoctrine()->getManager()->getRepository('EsterenPagesBundle:Menus')->findTree('Administration');
		return array(
            'links' => $links,
            'route' => $route,
        );
	}
}
