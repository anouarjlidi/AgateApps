<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\DoctrineListeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use EsterenMaps\MapsBundle\Cache\ClearerEntityInterface;
use EsterenMaps\MapsBundle\Cache\CacheManager;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\MarkersTypes;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\TransportModifiers;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use EsterenMaps\MapsBundle\Entity\Zones;
use EsterenMaps\MapsBundle\Entity\ZonesTypes;

class CacheClearSubscriber implements EventSubscriber
{
    /**
     * @var CacheManager
     */
    private $cacheService;

    public function __construct(CacheManager $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'postPersist',
            'postUpdate',
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->clearCache($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->clearCache($args);
    }

    private function clearCache(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // Clear the map cache if the entity corresponds to a specific class.
        if ($entity instanceof ClearerEntityInterface) {
            $this->cacheService->getAdapter()->deleteItem(CacheManager::CACHE_NAME);
        }
    }
}
