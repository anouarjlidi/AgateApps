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

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AssetsController extends Controller
{
    /**
     * @Route("/js/translations", name="pierstoval_tools_assets_jstranslations", host="%agate_domains.portal%", methods={"GET"})
     */
    public function jsTranslationsAction(Request $request, $_locale)
    {
        $response = new Response();

        $response->setCache([
            'etag' => sha1('js'.$_locale.$this->getParameter('version_code')),
            'last_modified' => new \DateTime($this->getParameter('version_date')),
            'max_age' => 600,
            's_maxage' => 600,
            'public' => true,
        ]);

        if ($response->isNotModified($request)) {
            return $response;
        }

        $response->headers->add(['Content-type' => 'application/javascript']);

        return $this->render('@Agate/assets/js_translations.js.twig', [
            'locale' => $_locale,
        ], $response);
    }
}
