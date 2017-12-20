<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Admin\Controller;

use Esteren\Entity\Page;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @Security("has_role('ROLE_ADMIN_MANAGE_SITE')")
 */
class PageController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/page/preview/{id}", name="admin_page_preview", methods={"GET"})
     */
    public function indexAction(Page $page): Response
    {
        return new Response($this->twig->render('easy_admin/Pages/preview.html.twig', [
            'pages' => [],
            'page'  => $page,
        ]));
    }
}
