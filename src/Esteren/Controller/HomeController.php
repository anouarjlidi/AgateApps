<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esteren\Controller;

use Agate\Entity\PortalElement;
use Agate\Exception\PortalElementNotFound;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/", name="esteren_portal_home", methods={"GET"})
     */
    public function indexAction(string $_locale, Request $request): Response
    {
        $portalElement = $this->getDoctrine()->getRepository(PortalElement::class)->findOneBy([
            'locale' => $_locale,
            'portal' => 'esteren',
        ]);

        if (!$portalElement) {
            throw new PortalElementNotFound('esteren', $_locale);
        }

        $response = new Response();
        $response->setCache([
            'max_age' => 600,
            's_maxage' => 600,
            'public' => $this->getUser() ? false : true,
        ]);

        $template = 'esteren/index-'.$_locale.'.html.twig';

        return $this->render($template, [
            'portal_element' => $portalElement,
        ], $response);
    }
}
