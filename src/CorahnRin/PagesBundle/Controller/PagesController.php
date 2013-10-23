<?php

namespace CorahnRin\PagesBundle\Controller;

use CorahnRin\PagesBundle\Pages as Pages;

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
     * @Route("/{id}-{slug}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function viewAction(Pages $page)
    {
		return array('page' => $page);
    }

    /**
     * @Route("/admin/pages/modify/{id}")
     * @Template()
     */
    public function modifyAction($id)
    {
		return array();
    }

    /**
     * @Route("/admin/pages/delete")
     * @Template()
     */
    public function deleteAction()
    {
		return array();
    }

    /**
     * @Route("/admin/pages/create")
     * @Template()
     */
    public function createAction()
    {
		return array();
    }

}
