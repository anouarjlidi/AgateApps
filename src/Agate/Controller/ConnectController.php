<?php

namespace Agate\Controller;

use Agate\EventListener\MultidomainConnectSubscriber;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ConnectController extends Controller
{
    /**
     * @Route("/connect/{id}", name="connect", methods={"POST"})
     */
    public function connectAction()
    {
        throw new \RuntimeException(sprintf(
            'This controller should not be called. This means that %s listener has not been executed correctly.',
            MultidomainConnectSubscriber::class
        ));
    }
}
