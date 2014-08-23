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
        return new Response('Login');
    }

    /**
     * @Route("/admin_check", name="sonata_admin_security_check")
     */
    public function checkAction()
    {
        return new Response('Check');
    }

    /**
     * @Route("/admin/logout", name="sonata_admin_security_logout")
     */
    public function logoutAction()
    {
        return new Response('Logout');
    }

} 