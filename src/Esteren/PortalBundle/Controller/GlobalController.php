<?php

namespace Esteren\PortalBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class GlobalController extends Controller
{
    /**
     * @param Request $request
     * @Route("/", name="root")
     * @return RedirectResponse
     */
    public function rootAction(Request $request)
    {
        $host = $request->getHost();

        if ($host === $this->container->getParameter('esteren_domains.backoffice')) {
            // Admin first
            return $this->redirect($this->generateUrl('admin', $request->query->all(), UrlGeneratorInterface::ABSOLUTE_URL));
        }

        $requestUri = $request->server->get('REQUEST_URI');
        if  (!preg_match('~('.$this->container->getParameter('locales_regex').')/?$~isU', $requestUri)) {
            $url = rtrim($request->getSchemeAndHttpHost(), '/') . rtrim($requestUri, '/') . '/' . $this->container->getParameter('locale') . '/';
            return $this->redirect($url);
        }

        throw $this->createNotFoundException('Route not found. #1');
    }

}
