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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UserBundle\Entity\User;
use UserBundle\Form\Type\ChangePasswordFormType;

class ChangePasswordController extends Controller
{
    /**
     * @Route("/profile/change-password", name="user_change_password")
     * @Method({"GET", "POST"})
     */
    public function changePasswordAction(Request $request): Response
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof User) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->createForm(ChangePasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('change_password.flash.success', [], 'UserBundle'));

            return $this->redirectToRoute('user_profile_edit');
        }

        return $this->render('@User/ChangePassword/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
