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
		return array();
    }

    /**
     * @Route("/generate/{step}-{slug}", requirements={"step" = "\d+"})
     * @Template("CorahnRinCharactersBundle:Generator:step_base.html.twig")
     */
    public function stepAction(\CorahnRin\CharactersBundle\Entity\Steps $step) {
		$datas = array('loaded_step'=>$step);
		
		return $datas;
	}
	
	/**
	 * @Template()
	 */
	public function menuAction() {
		$actual_step = (int) $this->get('session')->get('step');
		if (!$actual_step) { $actual_step = 1; }
    	$steps = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Steps')->findAll();
    	return array('steps'=>$steps, 'session_step' => $actual_step);
	}

}
