<?php

namespace AgateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route(host="%vermine_domains.portal%")
 */
class VermineController extends Controller
{
    /**
     * @Route("/", name="vermine_portal_home")
     */
    public function indexAction()
    {
        return $this->render('@Agate/vermine/vermine-home.html.twig');
    }
}
