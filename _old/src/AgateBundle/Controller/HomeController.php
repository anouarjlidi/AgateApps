<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AgateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(host="%agate_domains.portal%")
 */
class HomeController extends Controller
{
    /**
     * @Route("/", name="agate_portal_home", methods={"GET"})
     */
    public function indexAction(string $_locale, Request $request, string $_route): Response
    {
        $response = new Response();
        if (!$this->getParameter('kernel.debug')) {
            $response->setCache([
                'last_modified' => new \DateTime($this->getParameter('version_date')),
                'max_age' => 600,
                's_maxage' => 600,
                'public' => $this->getUser() ? false : true,
            ]);
        }

        if ($response->isNotModified($request)) {
            return $response;
        }

        $template = '@Agate/home/index-'.$_locale.'.html.twig';

        if (!$this->get('templating')->exists($template)) {
            return $this->redirectToRoute($_route, ['_locale' => 'fr']);
        }

        return $this->render($template, [], $response);
    }

    /**
     * @Route("/team", name="agate_team", methods={"GET"})
     */
    public function teamAction(Request $request): Response
    {
        $response = new Response();
        if (!$this->getParameter('kernel.debug')) {
            $response->setCache([
                'last_modified' => new \DateTime($this->getParameter('version_date')),
                'max_age' => 600,
                's_maxage' => 600,
                'public' => $this->getUser() ? false : true,
            ]);
        }

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $this->render('@Agate/home/team.html.twig', [], $response);
    }
}
