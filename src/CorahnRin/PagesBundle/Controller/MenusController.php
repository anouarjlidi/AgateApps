<?php

namespace CorahnRin\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MenusController extends Controller {
	/**
	 * @Template()
	 */
	public function menuAction($route = '') {
		$links = array(
			'corahnrin_characters_generator_index' => 'Générateur de personnage',
			'corahnrin_pages_versions_index' => 'Mises à jour',
		);
		$username = $this->get('fos_user.user_provider.username');
		return array('links' => $links, 'route_name' => $route);
	}

	/**
	 * @Template()
	 */
	public function adminAction() {
		return new Response('menu 1');
	}

}
