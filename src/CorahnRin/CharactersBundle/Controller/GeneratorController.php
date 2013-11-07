<?php

namespace CorahnRin\CharactersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GeneratorController extends Controller
{
    /**
     * @Route("/characters/create")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/characters/generate/{step}-{slug}", requirements={"step" = "\d+"})
     * @Template("CorahnRinCharactersBundle:Generator:step_base.html.twig")
     */
    public function stepAction(\CorahnRin\CharactersBundle\Entity\Steps $step) {
            $datas = array('loaded_step'=>$step);
            
            return $datas;
    }
	
    /**
     * @Template()
     */
    public function menuAction(\CorahnRin\CharactersBundle\Entity\Steps $step = null) {
        $actual_step = (int) $this->get('session')->get('step') ?: 1;
        $steps = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Steps')->findAll();
        $barWidth = count($steps) ? ($actual_step / count($steps) * 100) : 0;
        return array('steps'=>$steps, 'session_step' => $actual_step, 'bar_width' => $barWidth, 'loaded_step' => $step);
    }

}
