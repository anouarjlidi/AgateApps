<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CorahnRin\MapsBundle\Entity\Maps;
use CorahnRin\MapsBundle\Form\MapsType;

class MapsController extends Controller
{
    /**
     * @Route("/marker")
     * @Template()
     */
    public function viewAction()
    {
    }

    /**
     * @Route("/create")
     * @Template()
     */
    public function createAction()
    {
		$valid = false;
		$map = new Maps();
		
		$form = $this->createForm(new MapsType, $map);

		$request = $this->get('request');
		
		if ($request->getMethod() == 'POST') {
			$form->bind($request);
			
			if ($form->isValid()) {
				$valid = true;
//				$em = $this->getDoctrine()->getManager();
//				$em->persist($map);
//				$em->flush();
			}
		}
		
		return array('form' => $form->createView(), 'map' => $map, 'valid' => $valid);
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
    }

}
