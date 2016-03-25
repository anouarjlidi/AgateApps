<?php

namespace Pierstoval\Bundle\ToolsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class AssetsController extends Controller
{
    /**
     * @Route("/js/translations.js", name="pierstoval_tools_assets_jstranslations")
     * @Method("GET")
     * @Cache(maxage=86400, expires="+1 day")
     *
     * @param string $_locale
     *
     * @return Response
     */
    public function jsTranslationsAction($_locale)
    {
        $response = new Response();
        $response->headers->add(array('Content-type' => 'application/javascript'));

        $datas = array(
            'locale' => $_locale,
        );

        return $this->render('PierstovalToolsBundle:Assets:jsTranslations.js.twig', $datas, $response);
    }
}
