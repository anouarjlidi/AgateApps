<?php

namespace Application\Sonata\AdminBundle\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller {

    /**
     * @Route("/admin_login", name="sonata_admin_security_login")
     */
    public function loginAction()
    {
        $controller = $this->container->get('fos_user.services.security_controller');
        $controller->setContainer($this->container);
        return $controller->loginAction();
    }

    /**
     * @Route("/admin_check", name="sonata_admin_security_check")
     */
    public function checkAction()
    {
        return new Response('Check');
    }

    /**
     * @Route("/logout", name="sonata_admin_security_logout", host="%esteren_domains.backoffice%")
     */
    public function logoutAction()
    {
        return new Response('Logout');
    }

} 