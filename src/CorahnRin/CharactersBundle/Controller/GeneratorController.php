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
    	$repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Steps');
    	$datas = $repo->findAll();
    	return array('datas'=>$datas);
    }

    /**
     * @Route("/generate/{id}-{slug}", requirements={"id" = "\d+"},)
     * @Template()
     */
    public function stepAction($id, $slug) {
    	return array();
    }

}
