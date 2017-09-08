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
 * @Route(host="%vermine_domains.portal%")
 */
class VermineController extends Controller
{
    /**
     * @Route("/", name="vermine_portal_home", methods={"GET"})
     */
    public function indexAction(Request $request): Response
    {
        $response = new Response();
        $response->setCache([
            'last_modified' => new \DateTime($this->getParameter('version_date')),
            'max_age' => 600,
            's_maxage' => 600,
            'public' => true,
        ]);

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $this->render('@Agate/vermine/vermine-home.html.twig', [], $response);
    }
}
