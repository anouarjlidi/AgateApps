<?php

namespace CorahnRin\CharactersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GeneratorController extends Controller
{
    /**
     * @Route("/generate")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/generate/{id}_{slug}")
     * @Template()
     */
    public function stepAction($id, $slug)
    {
    }

}
