<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use EsterenMaps\Api\RouteApi;
use EsterenMaps\Entity\Routes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route(host="%esteren_domains.api%")
 */
class ApiRoutesController
{
    use ApiValidationTrait;

    private $security;
    private $em;
    private $routeApi;

    public function __construct(
        AuthorizationCheckerInterface $security,
        RouteApi $routeApi,
        EntityManagerInterface $em
    ) {
        $this->security = $security;
        $this->em = $em;
        $this->routeApi = $routeApi;
    }

    /**
     * @Route("/routes", name="maps_api_routes_create", methods={"POST"}, defaults={"_format": "json"})
     */
    public function create(Request $request): Response
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException();
        }

        try {
            $route = Routes::fromApi($this->routeApi->sanitizeRequestData(json_decode($request->getContent(), true)));

            return $this->handleResponse($this->validate($route), $route);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    /**
     * @Route("/routes/{id}", name="maps_api_routes_update", methods={"POST"}, defaults={"_format": "json"})
     */
    public function update(Routes $route, Request $request): Response
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedHttpException('Access denied.');
        }

        try {
            $route->updateFromApi($this->routeApi->sanitizeRequestData(json_decode($request->getContent(), true)));

            return $this->handleResponse($this->validate($route), $route);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    private function handleResponse(array $messages, Routes $route): Response
    {
        if (count($messages) > 0) {
            $response = new JsonResponse($messages, 400);
        } else {
            $this->em->persist($route);
            $this->em->flush();

            $response = new JsonResponse($route->toArray(), 200);
        }

        return $response;
    }

    private function handleException(\Throwable $exception): Response
    {
        $response = new JsonResponse();
        $response->setStatusCode(400);

        if ($exception instanceof HttpException) {
            $response->setStatusCode($exception->getStatusCode());
        }

        $response->setContent($exception->getMessage());

        return $response;
    }
}
