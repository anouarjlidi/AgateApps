<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MarkersController extends Controller
{
    /**
     * @Route("/admin/maps/markers")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/admin/maps/markers/add")
     * @Template()
     */
    public function addAction()
    {
    }

    /**
     * @Route("/admin/maps/markers/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
    }

    /**
     * @Route("/admin/maps/markers/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
    }


}
