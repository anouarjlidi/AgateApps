<?php

namespace AdminBundle\Controller;

use Esteren\PortalBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Security("has_role('ROLE_ADMIN_MANAGE_SITE')")
 */
class PageController extends Controller
{
    /**
     * @Route("/page/preview/{id}", name="admin_page_preview")
     */
    public function indexAction(Page $page)
    {
        return $this->render('easy_admin/Pages/preview.html.twig', [
            'pages' => [],
            'page' => $page,
        ]);
    }
}
