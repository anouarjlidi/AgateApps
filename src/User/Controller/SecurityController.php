<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace User\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use User\Entity\User;
use User\Security\FormLoginAuthenticator;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="user_login", methods={"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        if ($this->getUser() instanceof User) {
            return $this->redirect('/'.$request->getLocale().'/');
        }

        /** @var $session Session */
        $session = $request->getSession();

        $authErrorKey    = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        } elseif ($error) {
            $this->addFlash('error', $error->getMessage());
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;

        return $this->render('user/Security/login.html.twig', [
            'last_username'       => $lastUsername,
            'csrf_token'          => $csrfToken,
            'username_form_field' => FormLoginAuthenticator::USERNAME_OR_EMAIL_FORM_FIELD,
            'password_form_field' => FormLoginAuthenticator::PASSWORD_FORM_FIELD,
        ]);
    }
}
