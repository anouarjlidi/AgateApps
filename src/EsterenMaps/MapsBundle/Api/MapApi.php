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
use EsterenMaps\MapsBundle\Cache\CacheManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\Zones;

class MapApi
{
    private $em;
    private $cache;

    public function __construct(EntityManager $em, CacheManager $cache)
    {
        $this->em = $em;
        $this->cache = $cache;
    }

    public function getMap($id): array
    {
        $map = $this->em->getRepository(Maps::class)->findForApi($id);

        $map['markers'] = $this->em->getRepository(Markers::class)->findForApiByMap($id);
        $map['routes'] = $this->em->getRepository(Routes::class)->findForApiByMap($id);
        $map['zones'] = $this->em->getRepository(Zones::class)->findForApiByMap($id);

        return $map;
    }
}
