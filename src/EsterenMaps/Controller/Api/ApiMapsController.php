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

use EsterenMaps\Api\MapApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{
    JsonResponse, Request
};

/**
 * @Route(host="%esteren_domains.api%")
 */
class ApiMapsController extends AbstractController
{
    private $api;
    private $versionCode;

    public function __construct(string $versionCode, MapApi $api)
    {
        $this->api = $api;
        $this->versionCode = $versionCode;
    }

    /**
     * @Route("/maps/{id}", name="maps_api_maps_get", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function getAction(int $id, Request $request): JsonResponse
    {
        $response = new JsonResponse();

        $response->setEtag($etag = sha1('map'.$id.$this->versionCode));

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $response
            ->setData($this->api->getMap($id))
            ->setCache([
                'etag'          => $etag,
                'max_age'       => 600,
                's_maxage'      => 600,
                'public'        => true,
            ])
        ;
    }

    /**
     * @Route("/maps/{id}/edit-mode", name="maps_api_maps_get_editmode", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function getEditModeAction(int $id, Request $request): JsonResponse
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            // We need 404 instead of 403 to avoid dirty hacks here.
            throw $this->createNotFoundException();
        }

        return new JsonResponse($this->api->getMap($id, true));
    }
}
