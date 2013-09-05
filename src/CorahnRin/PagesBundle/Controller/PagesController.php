<?php

namespace CorahnRin\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PagesController extends Controller {
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
		$v = '';
		return array('v'=>$v);
    }

    /**
     * @Route("/{id}_-_{slug}")
     * @Template()
     */
    public function viewAction($id, $slug)
    {
    }

    /**
     * @Route("/admin/pages/modify/{id}")
     * @Template()
     */
    public function modifyAction($id)
    {
    }

    /**
     * @Route("/admin/pages/delete")
     * @Template()
     */
    public function deleteAction()
    {
    }

    /**
     * @Route("/admin/pages/create")
     * @Template()
     */
    public function createAction()
    {
    }

}
