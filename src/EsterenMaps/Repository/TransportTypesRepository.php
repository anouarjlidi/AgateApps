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
use EsterenMaps\Entity\TransportTypes;

class TransportTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransportTypes::class);
    }

    public function findForApi()
    {
        $query = $this->createQueryBuilder('transport_type')
            ->select('
                transport_type.id,
                transport_type.name,
                transport_type.slug,
                transport_type.description,
                transport_type.speed
            ')
            ->indexBy('transport_type', 'transport_type.id')
            ->getQuery()
        ;

        $query->useResultCache(true, 3600, CacheManager::CACHE_PREFIX.'api_transports_types');

        return $query->getArrayResult();
    }
}
