<?php

namespace Esteren\PortalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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

        return $this->render('@EsterenPortal/legal/mentions_'.$_locale.'.html.twig');
    }
}
