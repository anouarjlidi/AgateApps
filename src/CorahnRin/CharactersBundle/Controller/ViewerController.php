<?php

namespace CorahnRin\CharactersBundle\Controller;

use CorahnRin\CharactersBundle\Entity\Characters;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ViewerController extends Controller
{
    /**
     * @Route("/{id}-{nameSlug}", requirements={"id" = "\d+"})
     * @Template()
     */
    public function viewAction(Characters $character)
    {
		$str = \Doctrine\Common\Util\Debug::dump($character);
		return array('character'=>$character, 'dump'=>$str);
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function listAction()
    {	
		$request = $this->getRequest();
		$orderget = $request->query->get('field') ?: 'name';
		$ordertype = $request->query->get('type') ?: 'asc';
		$ordertype = strtolower($ordertype) === 'desc' ? 'desc' : 'asc';
		$repo = $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Characters');
    	$datas = $repo->findBy(array(), array($orderget=>$ordertype));
		return array('list'=>$datas,'ordertype' => $ordertype, 'orderget' => $orderget);
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
