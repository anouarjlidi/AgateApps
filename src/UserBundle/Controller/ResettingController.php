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

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UserBundle\Form\Type\ResettingFormType;

/**
 * @Route("/resetting")
 */
class ResettingController extends Controller
{
    /**
     * @Route("/request", name="user_resetting_request")
     * @Method("GET")
     */
    public function requestAction()
    {
        return $this->render('@User/Resetting/request.html.twig');
    }

    /**
     * @Route("/send-email", name="user_resetting_send_email")
     * @Method("POST")
     */
    public function sendEmailAction(Request $request)
    {
        $username = $request->request->get('username');

        $user = $this->get('user.repository')->findOneByEmail($username);

        if (null !== $user) {
            if (null === $user->getConfirmationToken()) {
                $user->setConfirmationToken($this->get('user.util.token_generator')->generateToken());
            }

            $this->get('user.mailer')->sendResettingEmailMessage($user);
        }

        return new RedirectResponse($this->generateUrl('user_resetting_check_email', array('username' => $username)));
    }

    /**
     * @Route("/check-email", name="user_resetting_check_email")
     * @Method("GET")
     */
    public function checkEmailAction(Request $request)
    {
        $username = $request->query->get('username');

        if (empty($username)) {
            // the user does not come from the sendEmail action
            return new RedirectResponse($this->generateUrl('user_resetting_request'));
        }

        return $this->render('@User/Resetting/check_email.html.twig');
    }

    /**
     * @Route("/reset/{token}", name="user_resetting_reset")
     * @Method({"GET", "POST"})
     */
    public function resetAction(Request $request, $token)
    {
        $user = $this->get('user.repository')->findByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with "confirmation token" does not exist for value "%s"', $token));
        }

        $form = $this->createForm(ResettingFormType::class, $user);
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('resetting.flash.success', [], 'UserBundle'));

            return new RedirectResponse($this->generateUrl('user_profile_edit'));
        }

        return $this->render('@User/Resetting/reset.html.twig', array(
            'token' => $token,
            'form' => $form->createView(),
        ));
    }
}
