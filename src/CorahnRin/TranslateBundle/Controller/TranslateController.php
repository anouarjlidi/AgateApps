<?php

namespace CorahnRin\TranslateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TranslateController extends Controller
{
    /**
     * @Route("/admin/translate")
     * @Template()
     */
    public function indexAction()
    {
    }

    /**
     * @Route("/admin/translate/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
    }

    /**
     * @Route("/admin/translate/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
    }

}
