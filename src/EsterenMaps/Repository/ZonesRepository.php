<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use EsterenMaps\Cache\CacheManager;
use EsterenMaps\Entity\Zones;
use Orbitale\Component\DoctrineTools\EntityRepositoryHelperTrait;

class ZonesRepository extends ServiceEntityRepository
{
    use EntityRepositoryHelperTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zones::class);
    }

    public function findForApiByMap($mapId)
    {
        $query = $this->createQueryBuilder('zone')
            ->select('
                zone.id,
                zone.name,
                zone.description,
                zone.coordinates,
                zoneFaction.id as faction,
                zoneType.id as zone_type
            ')
            ->leftJoin('zone.map', 'map')
            ->leftJoin('zone.faction', 'zoneFaction')
            ->leftJoin('zone.zoneType', 'zoneType')
            ->indexBy('zone', 'zone.id')
            ->where('map.id = :id')
            ->setParameter('id', $mapId)
            ->getQuery()
        ;

        $query->useResultCache(true, 3600, CacheManager::CACHE_PREFIX."api_map_$mapId\_zones");

        return $query->getArrayResult();
    }
}
