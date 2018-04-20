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

use Doctrine\Common\Persistence\ObjectManager;
use EsterenMaps\Entity\Routes;
use EsterenMaps\Repository\FactionsRepository;
use EsterenMaps\Repository\MapsRepository;
use EsterenMaps\Repository\MarkersRepository;
use EsterenMaps\Repository\RoutesRepository;
use EsterenMaps\Repository\RoutesTypesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * @Route(host="%esteren_domains.api%")
 */
class ApiRoutesController
{
    use ApiValidationTrait;

    private $em;
    private $routesTypesRepository;
    private $mapsRepository;
    private $markersRepository;
    private $factionsRepository;

    public function __construct(
        ObjectManager $em,
        RoutesRepository $routesRepository,
        RoutesTypesRepository $routesTypesRepository,
        MapsRepository $mapsRepository,
        MarkersRepository $markersRepository,
        FactionsRepository $factionsRepository
    ) {
        $this->routesTypesRepository = $routesTypesRepository;
        $this->mapsRepository = $mapsRepository;
        $this->markersRepository = $markersRepository;
        $this->factionsRepository = $factionsRepository;
        $this->em = $em;
    }

    /**
     * @Route("/routes", name="maps_api_routes_create", methods={"POST"}, defaults={"_format": "json"})
     */
    public function create(Request $request): Response
    {
        try {
            $route = Routes::fromApi($this->getDataFromRequest($request));

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
        try {
            $route->updateFromApi($this->getDataFromRequest($request));

            return $this->handleResponse($this->validate($route), $route);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    private function handleResponse(array $messages, Routes $route)
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

    private function handleException(\Throwable $exception)
    {
        $response = new JsonResponse();
        $response->setStatusCode(400);

        if ($exception instanceof HttpException) {
            $response->setStatusCode($exception->getStatusCode());
        }

        $response->setContent($exception->getMessage());

        return $response;
    }

    private function getDataFromRequest(Request $request): array
    {
        $json = json_decode($request->getContent(), true);

        if (isset($json['map'])) {
            $json['map'] = $this->mapsRepository->find($json['map']);
        }
        if (isset($json['faction'])) {
            $json['faction'] = $this->factionsRepository->find($json['faction']);
        }
        if (isset($json['routeType'])) {
            $json['routeType'] = $this->routesTypesRepository->find($json['routeType']);
        }
        if (isset($json['markerStart'])) {
            $json['markerStart'] = $this->markersRepository->find($json['markerStart']);
        }
        if (isset($json['markerEnd'])) {
            $json['markerEnd'] = $this->markersRepository->find($json['markerEnd']);
        }

        return $json;
    }
}
