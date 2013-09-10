<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MarkersController extends Controller
{
    /**
     * @Route("/markers")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/markers/add")
     * @Template()
     */
    public function addAction()
    {
    }

    /**
     * @Route("/markers/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
    }

    /**
     * @Route("/markers/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
    }


}
