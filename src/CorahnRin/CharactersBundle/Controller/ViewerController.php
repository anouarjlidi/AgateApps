<?php

namespace CorahnRin\CharactersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ViewerController extends Controller
{
    /**
     * @Route("/{id}-{name}")
     * @Template()
     */
    public function viewAction($id, $name)
    {
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function listAction()
    {
    }

    /**
     * @Route("/pdf/{id}-{name}.pdf")
     * @Template()
     */
    public function pdfAction($id, $name)
    {
    }

    /**
     * @Route("/zip/{id}-{name}.zip")
     * @Template()
     */
    public function zipAction($id, $name)
    {
    }

    /**
     * @Route("/jpg/{id}-{name}.zip")
     * @Template()
     */
    public function jpgAction($id, $name)
    {
    }

}
