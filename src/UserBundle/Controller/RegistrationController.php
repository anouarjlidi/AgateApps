<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use UserBundle\Form\Type\RegistrationFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;
use UserBundle\Repository\UserRepository;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_register")
     * @Method({"GET", "POST"})
     */
    public function registerAction(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('user_profile_edit');
        }

        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword()));
            $user->setConfirmationToken($this->get('user.util.token_generator')->generateToken());
            $user->setEmailConfirmed(false);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('user.mailer')->sendRegistrationEmail($user);

            $this->addFlash('success', $this->get('translator')->trans('registration.confirmed', ['%username%' => $user->getUsername()], 'UserBundle'));

            $request->getSession()->set(Security::LAST_USERNAME, $user->getUsername());

            return $this->redirectToRoute('user_login');
        }

        return $this->render('@User/Registration/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/check-email", name="user_check_email")
     */
    public function checkEmailAction(Request $request)
    {
        $session = $request->getSession();

        $email = $session->get('user_send_confirmation_email/email');

        if (empty($email)) {
            return $this->redirectToRoute('user_register');
        }

        $session->remove('user_send_confirmation_email/email');
        $user = $this->get(UserRepository::class)->findOneByEmail($email);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with email "%s" does not exist', $email));
        }

        return $this->render('@User/Registration/check_email.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * @Route("/register/confirm/{token}", name="user_registration_confirm", requirements={"token": ".+"})
     * @Method("GET")
     */
    public function confirmAction(string $token, string $_locale)
    {
        /** @var User|null $user */
        $user = $this->get(UserRepository::class)->findOneBy(['confirmationToken' => $token]);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        $user->setConfirmationToken(null);
        $user->setEmailConfirmed(true);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', $this->get('translator')->trans('registration.confirmed', ['%username%' => $user->getUsername()], 'UserBundle'));

        return $this->redirect('/'.$_locale);
    }
}
