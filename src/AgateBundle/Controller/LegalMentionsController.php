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
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(host="%agate_domains.portal%")
 */
class LegalMentionsController extends Controller
{
    /**
     * @Route("/legal", name="legal_mentions")
     *
     * @param string $_locale
     *
     * @return Response
     */
    public function legalMentionsAction($_locale)
    {
        if ($_locale !== 'fr') {
            throw $this->createNotFoundException();
        }

        return $this->render('@Agate/legal/mentions_'.$_locale.'.html.twig');
    }
}