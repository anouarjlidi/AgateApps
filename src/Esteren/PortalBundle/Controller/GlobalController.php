<?php

namespace Esteren\PortalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GlobalController extends Controller
{
    /**
     * @param Request $request
     * @Route("/", name="root")
     * @return RedirectResponse
     */
    public function rootAction(Request $request)
    {
        $locale = $this->container->getParameter('locale');
        $requestUri = $request->server->get('REQUEST_URI');
        if  (!preg_match('~('.$this->container->getParameter('locales_regex').')/?$~isU', $requestUri)) {
            $url = rtrim($request->getSchemeAndHttpHost(), '/') . rtrim($requestUri, '/') . '/' . $locale . '/';
            return $this->redirect($url);
        }
        return new Response('root');
    }

}
