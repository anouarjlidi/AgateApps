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
use UserBundle\Form\Type\ProfileFormType;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="user_profile_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request): Response
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof User) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $form = $this->createForm(ProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('profile.flash.updated', [], 'UserBundle'));

            return $this->redirectToRoute('user_profile_edit');
        }

        return $this->render('@User/Profile/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
