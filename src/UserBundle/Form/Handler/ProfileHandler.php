<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use UserBundle\Entity\User;

final class ProfileHandler
{
    private $em;
    private $router;
    private $translator;

    /**
     * @var Request
     */
    private $request;

    public function __construct(EntityManager $em, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->em = $em;
        $this->router = $router;
        $this->translator = $translator;
    }

    public function handle(Request $request, Form $editProfileForm, Form $ululeConnectForm): ?Response
    {
        $this->request = $request;

        if ($result = $this->handleEditProfileForm($editProfileForm)) {
            return $this->returnResponse($result);
        }

        if ($result = $this->handleUluleConnectForm($ululeConnectForm)) {
            return $this->returnResponse($result);
        }

        return null;
    }

    private function returnResponse(Response $response)
    {
        $this->request = null;

        return $response;
    }

    private function handleUluleConnectForm(Form $form): ?Response
    {
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash('success', $this->translator->trans('profile.flash.updated', [], 'UserBundle'));

            return new RedirectResponse($this->router->generate('user_profile_edit').'#ulule_connect');
        }

        return null;
    }

    private function handleEditProfileForm(Form $form): ?Response
    {
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($form->getData());
            $this->em->flush();

            $this->addFlash('success', $this->translator->trans('profile.flash.updated', [], 'UserBundle'));

            return new RedirectResponse($this->router->generate('user_profile_edit').'#edit_profile');
        }

        return null;
    }

    private function addFlash(string $type, string $message)
    {
        $this->request->getSession()->getFlashBag()->add($type, $message);
    }
}
