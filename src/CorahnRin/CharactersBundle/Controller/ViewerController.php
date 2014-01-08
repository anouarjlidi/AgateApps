<?php

namespace CorahnRin\CharactersBundle\Controller;

use CorahnRin\CharactersBundle\Entity\Characters;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ViewerController extends Controller
{
    /**
     * @Route("/characters/{id}-{nameSlug}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function viewAction(Characters $character)
    {
		return array('character'=>$character);
    }

    /**
     * @Route("/characters/")
     * @Template()
     */
    public function listAction()
    {
		$request = $this->getRequest();
		$orderget = $request->query->get('field') ?: 'name';
		$ordertype = $request->query->get('order') ?: 'asc';
		$ordertype = strtolower($ordertype) === 'desc' ? 'desc' : 'asc';
		$repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Characters');
    	$datas = $repo->findBy(array(), array($orderget=>$ordertype));
        $orderlink = $ordertype === 'desc' ? 'asc' : 'desc';
		return array('list'=>$datas,'ordertype' => $ordertype,'orderlink' => $orderlink, 'orderget' => $orderget);
    }

    /**
     * @Route("/characters/pdf/{id}-{name}.pdf")
     * @Template()
     */
    public function pdfAction($id, $name)
    {
    }

    /**
     * @Route("/characters/zip/{id}-{name}.zip")
     * @Template()
     */
    public function zipAction($id, $name)
    {
    }

    /**
     * @Route("/characters/jpg/{id}-{name}.zip")
     * @Template()
     */
    public function jpgAction($id, $name)
    {
    }

}
