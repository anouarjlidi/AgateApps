<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Controller\Api;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(host="%esteren_domains.api%")
 */
class ApiMapsController extends Controller
{
    /**
     * @Route("/maps/{id}", name="esterenmaps_api_map_get", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function getAction(int $id, Request $request): JsonResponse
    {
        $mapApi = $this->get('esterenmaps.api.map');

        $response = new JsonResponse();
        $response->setLastModified($mapApi->getLastUpdateTime($id));

        if ($response->isNotModified($request)) {
            return $response;
        }

        $data = $mapApi->getMap($id);

        $response->setData($data);

        if (!$this->getParameter('kernel.debug')) {
            $response->setCache([
                'etag'          => sha1('map'.$id.$this->getParameter('version_code')),
                'last_modified' => new \DateTime($mapApi->getLastUpdateTime($id)),
                'max_age'       => 600,
                's_maxage'      => 600,
                'public'        => true,
            ]);
        }

        return $response;
    }
}
