<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Api;

use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Factions;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\MarkersTypes;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use EsterenMaps\MapsBundle\Entity\Zones;
use EsterenMaps\MapsBundle\Entity\ZonesTypes;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MapApi
{
    private $em;
    private $cache;
    private $twig;
    private $debug;

    public function __construct(EntityManager $em, TwigEngine $twig, AdapterInterface $cache, bool $debug)
    {
        $this->em = $em;
        $this->cache = $cache;
        $this->twig = $twig;
        $this->debug = $debug;
    }

    public function getMap($id)
    {
        $cacheItem = $this->cache->getItem('esterenmaps.api.map.'.$id);

        if (!$this->debug && $cacheItem->isHit()) {
            return json_decode($cacheItem->get(), true);
        }

        $data = $this->doGetMap($id);

        $cacheItem->set(json_encode($data));
        $this->cache->save($cacheItem);

        return $data;
    }

    private function doGetMap($id)
    {
        $data = [
            'map' => [],
            'templates' => [],
            'references' => [],
        ];

        // Map info
        $data['map'] = $this->em->getRepository(Maps::class)->findForApi($id);
        $data['map']['markers'] = $this->em->getRepository(Markers::class)->findForApiByMap($id);
        $data['map']['routes'] = $this->em->getRepository(Routes::class)->findForApiByMap($id);
        $data['map']['zones'] = $this->em->getRepository(Zones::class)->findForApiByMap($id);

        // References
        $data['references']['markers_types'] = $this->em->getRepository(MarkersTypes::class)->findForApi();
        $data['references']['routes_types'] = $this->em->getRepository(RoutesTypes::class)->findForApi();
        $data['references']['zones_types'] = $this->em->getRepository(ZonesTypes::class)->findForApi();
        $data['references']['factions'] = $this->em->getRepository(Factions::class)->findForApi();

        // Pre-compiled templates
        $data['templates']['LeafletPopupMarkerBaseContent'] = $this->twig->render('@EsterenMaps/Api/popupContentMarker.html.twig', [
            'markersTypes' => $data['references']['markers_types'],
            'factions'     => $data['references']['factions'],
        ]);
        $data['templates']['LeafletPopupPolylineBaseContent'] = $this->twig->render('@EsterenMaps/Api/popupContentPolyline.html.twig', [
            'markers'     => $data['map']['markers'],
            'routesTypes' => $data['references']['routes_types'],
            'factions'    => $data['references']['factions'],
        ]);
        $data['templates']['LeafletPopupPolygonBaseContent'] = $this->twig->render('@EsterenMaps/Api/popupContentPolygon.html.twig', [
            'zonesTypes' => $data['references']['zones_types'],
            'factions'   => $data['references']['factions'],
        ]);

        return $this->filterMapData($data);
    }

    private function filterMapData(array $data)
    {
        $data['map']['bounds'] = json_decode($data['map']['bounds'], true);

        foreach ($data['map']['markers'] as &$marker) {
            $marker['latitude'] = (float) $marker['latitude'];
            $marker['longitude'] = (float) $marker['longitude'];
        }

        foreach ($data['map']['zones'] as &$zone) {
            $zone['coordinates'] = $this->filterCoordinates(json_decode($zone['coordinates'], true));
        }

        foreach ($data['map']['routes'] as &$route) {
            $route['coordinates'] = $this->filterCoordinates(json_decode($route['coordinates'], true));
            if ($route['forced_distance']) {
                $route['distance'] = $route['forced_distance'];
            }
            unset($route['forced_distance']);
        }

        return $data;
    }

    private function filterCoordinates($coordinates)
    {
        foreach ($coordinates as &$coordinate) {
            $coordinate['lat'] = (float) $coordinate['lat'];
            $coordinate['lng'] = (float) $coordinate['lng'];
        }

        return $coordinates;
    }
}
