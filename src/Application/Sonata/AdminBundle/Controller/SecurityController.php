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
        return $this->redirect($this->generateUrl('sonata_admin_security_login'));
    }

    /**
     * @Route("/{_locale}/admin_login", name="sonata_admin_security_login", host="%esteren_domains.backoffice%")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $token = $this->container->get('security.context')->getToken();
        $user = $token ? $token->getUser() : null;

        if ($user instanceof UserInterface) {
            $this->container->get('session')->getFlashBag()->set('sonata_user_error', 'sonata_user_already_authenticated');
            $url = $this->container->get('router')->generate('sonata_user_profile_show');

            return new RedirectResponse($url);
        }

        /* @var $session Session */
        $session = $request->getSession();

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        if ($error) {
            // TODO: this is a potential security risk (see http://trac.symfony-project.org/ticket/9523)
            $error = $error->getMessage();
        }
        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContext::LAST_USERNAME);

        $csrfToken = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');

        return array(
            'last_username' => $lastUsername,
            'error'         => $error,
            'csrf_token' => $csrfToken,
        );
    }

    /**
     * @Route("/{_locale}/admin_check", name="sonata_admin_security_check", host="%esteren_domains.backoffice%")
     */
    public function checkAction()
    {
        return $this->forward('FOSUserBundle:Security:check');
    }

    /**
     * @Route("/{_locale}/logout", name="sonata_admin_security_logout", host="%esteren_domains.backoffice%")
     */
    public function logoutAction()
    {
        return $this->forward('FOSUserBundle:Security:logout');
    }

} 