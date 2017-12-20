<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\DoctrineListeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use EsterenMaps\Cache\EntityToClearInterface;
use EsterenMaps\Cache\CacheManager;

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
        if ($entity instanceof EntityToClearInterface) {
            $this->cacheService->clear();
        }
    }
}
