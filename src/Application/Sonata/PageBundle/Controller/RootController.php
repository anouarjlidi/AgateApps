<?php

namespace Application\Sonata\PageBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class RootController extends Controller {

    /**
     * @param Request $request
     * @Route("/", name="root")
     * @return RedirectResponse
     */
    public function rootAction(Request $request)
    {
        $url = $this->generateUrl($request->attributes->get('_route'), array(), true);
        $locale = $this->container->getParameter('locale');

        $url = rtrim($url, '/').'/'.$locale.'/';

        return $this->redirect($url);
    }

} 