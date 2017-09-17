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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;
use UserBundle\Form\Type\ResettingFormType;
use UserBundle\Repository\UserRepository;

/**
 * @Route("/resetting")
 */
class ResettingController extends Controller
{
    /**
     * @Route("/request", name="user_resetting_request", methods={"GET"})
     */
    public function requestAction()
    {
        return $this->render('@User/Resetting/request.html.twig');
    }

    /**
     * @Route("/send-email", name="user_resetting_send_email", methods={"POST"})
     */
    public function sendEmailAction(Request $request)
    {
        $username = $request->request->get('username');

        $user = $this->get(UserRepository::class)->findByUsernameOrEmail($username);

        if (null !== $user) {
            if (null === $user->getConfirmationToken()) {
                $user->setConfirmationToken($this->get('user.util.token_generator')->generateToken());
            }

            try {
                $this->get('user.mailer')->sendResettingEmailMessage($user);
                $this->getDoctrine()->getManager()->flush();
            } catch (\Exception $e) {
                $this->addFlash('user_error', 'user_errors.resetting_email_failed');

                return new RedirectResponse($this->generateUrl('user_resetting_request'));
            }
        }

        $this->addFlash('user_success', 'resetting.check_email');

        return new RedirectResponse($this->generateUrl('user_login'));
    }

    /**
     * @Route("/reset/{token}", name="user_resetting_reset", methods={"GET", "POST"})
     */
    public function resetAction(Request $request, $token)
    {
        $user = $this->get(UserRepository::class)->findOneByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $form = $this->createForm(ResettingFormType::class, $user);
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setConfirmationToken(null);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', $this->get('translator')->trans('resetting.flash.success', [], 'UserBundle'));
            $request->getSession()->set(Security::LAST_USERNAME, $user->getUsername());

            return new RedirectResponse($this->generateUrl('user_login'));
        }

        return $this->render('@User/Resetting/reset.html.twig', [
            'token' => $token,
            'form'  => $form->createView(),
        ]);
    }
}
