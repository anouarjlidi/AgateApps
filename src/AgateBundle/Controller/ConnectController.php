<?php

namespace AgateBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ConnectController extends Controller
{
    /**
     * @Route("/connect/{id}", name="connect", methods={"POST"})
     */
    public function connectAction($id, Request $request)
    {
        $session = $request->getSession();

        if ($session && $session->getId() === $id) {
            // Means sessions are synchronized between domains
            return new Response();
        }

        $storage = $this->get('session.storage');

        $storage->clear();
        $storage->save();
        $storage->setId($id);
        $storage->start();

        return new Response();
    }
}
