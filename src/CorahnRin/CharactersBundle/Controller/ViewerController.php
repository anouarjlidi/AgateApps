<?php

namespace CorahnRin\CharactersBundle\Controller;

use CorahnRin\CharactersBundle\Entity\Characters;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ViewerController extends Controller
{
    /**
     * @Route("/{id}-{nameSlug}", requirements={"id" = "\d+"})
	 * @ParamConverter("character", options={"mapping":{"id":"id","nameSlug":"nameSlug"}})
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
