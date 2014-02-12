<?php

namespace CorahnRin\CharactersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SocialClassesController extends Controller
{
    /**
     * @Route("/admin/generator/socialclass/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller','',preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:'.$name)->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/socialclass/add/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addAction()
    {
    }

    /**
     * @Route("/admin/generator/socialclass/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editAction($id)
    {
    }

    /**
     * @Route("/admin/generator/socialclass/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
    }

}
