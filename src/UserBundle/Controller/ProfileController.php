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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UserBundle\Entity\User;
use UserBundle\Form\Type\ProfileFormType;
use UserBundle\Form\Type\UluleConnectType;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="user_profile_edit", methods={"GET", "POST"})
     */
    public function editAction(Request $request): Response
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof User) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $editProfileForm  = $this->createForm(ProfileFormType::class, $user);
        $ululeConnectForm = $this->createForm(UluleConnectType::class, $user);

        if ($response = $this->get('user.form.handler.profile')->handle($request, $editProfileForm, $ululeConnectForm)) {
            return $response;
        }

        return $this->render('@User/Profile/edit.html.twig', [
            'form_edit_profile' => $editProfileForm->createView(),
            'form_ulule_connect' => $ululeConnectForm->createView(),
        ]);
    }
}
