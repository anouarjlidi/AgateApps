<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\Cache;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Psr\Cache\CacheItemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

/**
 * Standalone service to manage cache for EsterenMaps.
 * At first it's for Directions, but can be extended to other systems.
 */
class CacheManager implements EventSubscriber
{
    public const CACHE_PREFIX = 'esterenmaps_';

    private $cacheAdapter;
    private $logger;

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(AdapterInterface $cacheAdapter, LoggerInterface $logger)
    {
        $this->cacheAdapter = $cacheAdapter;
        $this->logger = $logger;
    }

    /**
     * @required
     */
    public function setEntityManager(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

    public function clearAppCache(): void
    {
        $itemsToDelete = [
            static::CACHE_PREFIX.'.api.directions',
            static::CACHE_PREFIX.'.api.maps',
        ];

        $this->cacheAdapter->deleteItems($itemsToDelete);
    }

    public function clearDoctrineCache(): void
    {
        if (!$this->em) {
            return;
        }

        $doctrineCache = $this->em->getConfiguration()->getResultCacheImpl();

        if (!$doctrineCache) {
            return;
        }

        $keys = $doctrineCache->getStats();

        $this->logger->info('Clearing doctrine cache', ['cache_stats' => $keys]);

        // Clear all Doctrine result cache keys that start with EsterenMap's prefix
        foreach ($keys as $key => $cache) {
            if (strpos($key, static::CACHE_PREFIX) === 0) {
                $doctrineCache->delete($key);
            }
        }
    }

    public function getItem(string $suffix = ''): CacheItem
    {
        return $this->cacheAdapter->getItem(static::CACHE_PREFIX.'.'.ltrim($suffix, '.'));
    }

    public function getItemValue(CacheItem $cacheItem, string $key)
    {
        $cacheValue = $cacheItem->isHit() ? $cacheItem->get() : null;

        return $cacheValue && is_array($cacheValue) && isset($cacheValue[$key])
            ? $cacheValue[$key]
            : null;
    }

    public function getValue($key)
    {
        $item = $this->getItem($key);

        return $this->getItemValue($item, $key);
    }

    public function saveItem(CacheItemInterface $item): bool
    {
        return $this->cacheAdapter->save($item);
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

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->clearCacheForEntity($args);
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $this->clearCacheForEntity($args);
    }

    private function clearCacheForEntity(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();

        // Clear the map cache if the entity corresponds to a specific class.
        if ($entity instanceof EntityToClearInterface) {
            $this->clearAppCache();
            $this->clearDoctrineCache();
        }
    }
}
