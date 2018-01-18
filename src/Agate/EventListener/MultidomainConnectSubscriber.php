<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class MultidomainConnectSubscriber implements EventSubscriberInterface
{
    private $sessionStorage;
    private $logger;

    public function __construct(SessionStorageInterface $sessionStorage, LoggerInterface $logger)
    {
        $this->sessionStorage = $sessionStorage;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        // Priority 9 is "right before Firewall".
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 9]],
        ];
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $route = $request->attributes->get('_route');

        if ($route !== 'connect' || !$request->isMethod('POST')) {
            return;
        }

        $id = $request->attributes->get('id');

        $session = $request->getSession();

        if ($session && $session->getId() === $id) {
            // Means sessions are synchronized between domains
            $this->logger->info("Request id '$id' identical to {$session->getId()}");
            $event->setResponse(new Response('ok'));

            return;
        }

        $this->logger->info("Request id '$id' identical to {$session->getId()}");

        $this->sessionStorage->clear();
        $this->sessionStorage->save();
        $this->sessionStorage->setId($id);
        $this->sessionStorage->start();

        $event->setResponse(new Response('synced'));
    }
}
