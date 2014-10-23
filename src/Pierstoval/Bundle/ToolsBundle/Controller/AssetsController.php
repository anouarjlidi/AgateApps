<?php

namespace Pierstoval\Bundle\ToolsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AssetsController extends Controller
{

    /**
     * @Route("/js/translations.js")
     */
    public function jsTranslationsAction($_locale)
    {
        $response = new Response();
        $response->headers->add(array('Content-type'=>'application/javascript'));

        $datas = array(
            'locale' => $_locale,
        );
        return $this->render('PierstovalToolsBundle:Assets:jsTranslations.js.twig', $datas, $response);
    }

}
