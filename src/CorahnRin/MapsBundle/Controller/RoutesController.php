<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RoutesController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/routes/add")
     * @Template()
     */
    public function addAction()
    {
    }

    /**
     * @Route("/routes/edit")
     * @Template()
     */
    public function editAction()
    {
    }

    /**
     * @Route("/routes/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
    }

}
