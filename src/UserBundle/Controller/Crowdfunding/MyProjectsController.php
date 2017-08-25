<?php

namespace UserBundle\Controller\Crowdfunding;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\ConnectApi\UluleClient;

class MyProjectsController extends Controller
{
    /**
     * @Route("/my_projects", name="cf_my_projects")
     * @Method("GET")
     * @Security("is_granted('ROLE_USER') and user.getUluleApiToken() and user.getUluleUsername()")
     */
    public function myProjectsAction(): Response
    {
        $projects = $this->get(UluleClient::class)->getUserProjects($this->getUser());

        return $this->render('@User/Crowdfunding/my_projects.html.twig', [
            'projects' => $projects,
        ]);
    }
}
