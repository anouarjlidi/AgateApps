<?php

namespace User\Controller\Crowdfunding;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use User\ConnectApi\UluleClient;

class MyProjectsController extends AbstractController
{
    private $ululeClient;

    public function __construct(UluleClient $ululeClient)
    {
        $this->ululeClient = $ululeClient;
    }

    /**
     * @Route("/my_projects", name="cf_my_projects", methods={"GET"})
     * @Security("is_granted('ROLE_USER') and user.getUluleApiToken() and user.getUluleUsername()")
     */
    public function myProjectsAction(): Response
    {
        $projects = $this->ululeClient->getUserProjects($this->getUser());

        return $this->render('user/Crowdfunding/my_projects.html.twig', [
            'projects' => $projects,
        ]);
    }
}
