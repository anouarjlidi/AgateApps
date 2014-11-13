<?php

namespace Application\Sonata\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sonata\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller {

    /**
     * @Route("/{_locale}/",  name="sonata_admin_root", host="%esteren_domains.backoffice%", defaults={"_locale":"fr"})
     */
    public function rootAction()
    {
        return $this->redirect($this->generateUrl('sonata_user_admin_security_login'));
    }

} 