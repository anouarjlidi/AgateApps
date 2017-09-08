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
 * @Route(host="%agate_domains.portal%", methods={"GET"})
 */
class LegalMentionsController extends Controller
{
    /**
     * @Route("/legal", name="legal_mentions")
     */
    public function legalMentionsAction(string $_locale, Request $request): Response
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

        if ($_locale !== 'fr') {
            throw $this->createNotFoundException();
        }

        return $this->render('@Agate/legal/mentions_'.$_locale.'.html.twig', [], $response);
    }
}
