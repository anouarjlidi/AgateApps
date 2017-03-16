<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pierstoval\Bundle\ApiBundle\Listeners;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonResponseListener implements EventSubscriberInterface
{
    /**
     * @var string
     */
    private $environment;

    public function __construct($environment)
    {
        $this->environment = $environment;
    }

    /**
     * Will force any response with the ApiController to have an "application/json" format.
     *
     * @param FilterResponseEvent $event
     */
    public function onResponse(FilterResponseEvent $event)
    {
        $controller = $event->getRequest()->attributes->get('_controller');

        if (strpos($controller, 'Pierstoval\Bundle\ApiBundle\Controller\ApiController') !== false) {
            $event->getResponse()->headers->set('Content-type', 'application/json', true);
        }
    }

    /**
     * Helps throwing exceptions with the ApiController, by transforming the exception into a JSON object.
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onException(GetResponseForExceptionEvent $event)
    {
        $controller = $event->getRequest()->attributes->get('_controller');

        if (strpos($controller, 'Pierstoval\Bundle\ApiBundle\Controller\ApiController') !== false) {

            // Stops any other kernel.exception listener to occur
            $event->stopPropagation();

            $e = $event->getException();

            $code = $e->getCode();

            $data = [
                'error'     => true,
                'message'   => $e->getMessage(),
                'exception' => [
                    'code' => $code,
                ],
            ];

            if ($this->environment === 'dev') {
                $data['exception']['file']          = $e->getFile();
                $data['exception']['line']          = $e->getLine();
                $data['exception']['traceAsString'] = $e->getTraceAsString();
                $data['exception']['trace']         = $e->getTrace();
            }

            // Checks that the exception code corresponds to any HTTP code
            $responseCode = isset(Response::$statusTexts[$code]) ? $code : 500;

            // Set a proper new response which will be JSON automatically
            $event->setResponse(new JsonResponse($data, $responseCode));
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE  => ['onResponse', 1],
            KernelEvents::EXCEPTION => ['onException', 1],
        ];
    }
}
