<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route(host="%esteren_domains.esterenmaps%")
 */
class MapsController extends Controller
{
    /**
     * @Route("/map-{nameSlug}", methods={"GET"})
     */
    public function viewAction(Maps $map, Request $request): Response
    {
        $response = new Response();
        if (!$this->getParameter('kernel.debug')) {
            $response->setCache([
                'last_modified' => $map->getUpdatedAt(),
                'max_age' => 600,
                's_maxage' => 600,
                'public' => true,
            ]);
        }

        if ($response->isNotModified($request)) {
            return $response;
        }

        $tilesUrl = $this->generateUrl('esterenmaps_api_tiles', ['id' => 0, 'x' => 0, 'y' => 0, 'zoom' => 0], true);
        $tilesUrl = str_replace('0/0/0/0', '{id}/{z}/{x}/{y}', $tilesUrl);
        $tilesUrl = preg_replace('~app_dev\.php/~iUu', '', $tilesUrl);

        return $this->render('@EsterenMaps/Maps/view.html.twig', [
            'map'       => $map,
            'tilesUrl'  => $tilesUrl,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
        ], $response);
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function indexAction(Request $request): Response
    {
        /** @var Maps[] $allMaps */
        $allMaps = $this->getDoctrine()->getRepository('EsterenMapsBundle:Maps')->findAllRoot();

        $updatedAt = null;

        foreach ($allMaps as $map) {
            if (!$updatedAt) {
                $updatedAt = $map->getUpdatedAt();
                continue;
            }
            if ($updatedAt < $map->getUpdatedAt()) {
                $updatedAt = $map->getUpdatedAt();
            }
        }

        $response = new Response();
        if (!$this->getParameter('kernel.debug')) {
            $response->setCache([
                'last_modified' => $updatedAt,
                'max_age'       => 600,
                's_maxage'      => 600,
                'public'        => true,
            ]);
        }

        if ($response->isNotModified($request)) {
            return $response;
        }

        return $this->render('@EsterenMaps/Maps/index.html.twig', [
            'list' => $allMaps,
        ], $response);
    }
}
