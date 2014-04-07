<?php

namespace CorahnRin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Route("/")
     * @Template("CorahnRinAdminBundle:Admin:layout.html.twig")
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

        $links = $this->getDoctrine()->getManager()->getRepository('CorahnRinPagesBundle:Menus')->findTree('Administration');
		return array(
            'links' => $links,
            'route' => $route,
        );
	}
}
