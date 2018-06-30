<?php

declare(strict_types=1);

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace User\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class SessionHostSubscriber implements EventSubscriberInterface
{
    private $sessionStorage;

    public function __construct(SessionStorageInterface $sessionStorage)
    {
        $this->sessionStorage = $sessionStorage;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        if ($this->sessionStorage instanceof NativeSessionStorage) {
            $host = $event->getRequest()->getHost();

            if (2 === substr_count($host, '.')) {
                // In this case, we have a subdomain, so we cut it for the cookie domain option.
                $host = preg_replace('~^[^.]+~', '', $host);
            }

            $this->sessionStorage->setOptions([
                'cookie_domain' => $host,
                'cookie_path' => '/',
            ]);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 1024],
        ];
    }
}
