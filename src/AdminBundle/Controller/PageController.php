<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AdminBundle\Controller;

use Esteren\PortalBundle\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            'page'  => $page,
        ]);
    }
}
