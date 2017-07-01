<?php

namespace AgateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VerminePortalController extends Controller {
	/**
	 * @Route("/", name="vermine_portal_home", host="%vermine_domains.portal%")
	 */
	public function indexAction() {
		return $this->render( '@Agate/vermine/index.html.twig' );
	}
}