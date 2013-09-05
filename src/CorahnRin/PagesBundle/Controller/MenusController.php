<?php

namespace CorahnRin\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MenusController extends Controller {
	/**
	 * @Template()
	 */
	public function menuAction() {
		$datas = array(
			'link1' => 'link',
		);
		$username = $this->get('fos_user.user_provider.username');
		return array('datas' => $datas);
	}

	/**
	 * @Template()
	 */
	public function adminAction() {
		return new Response('menu 1');
	}

}
