<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RoutesController extends Controller
{
    /**
     * @Route("/admin/maps/routes")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/admin/maps/routes/add")
     * @Template()
     */
    public function addAction()
    {
    }

    /**
     * @Route("/admin/maps/routes/edit")
     * @Template()
     */
    public function editAction()
    {
    }

    /**
     * @Route("/admin/maps/routes/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
    }

}
