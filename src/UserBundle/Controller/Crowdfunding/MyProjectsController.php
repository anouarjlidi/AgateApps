<?php

namespace UserBundle\Controller\Crowdfunding;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

class MyProjectsController extends Controller
{
    /**
     * @Route("/my_projects", name="cf_my_projects")
     * @Security("is_granted('ROLE_USER')")
     */
    public function myProjectsAction(Request $request): Response
    {
        /** @var User $user */
        $user = $this->getDoctrine()->getRepository(User::class)->findOneWithProjects($this->getUser()->getId());

        if ($request->isMethod('POST') && $request->request->has('sync')) {
            $ululeClient = $this->get('crowdfunding.project_manager.ulule');
            $ululeClient->updateProjectsFromUser($user);
            $ululeClient->updateUserContributions($user);
        }

        return $this->render('@User/Crowdfunding/my_projects.html.twig', [
            'user' => $user,
        ]);
    }
}
