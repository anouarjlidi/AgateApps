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

use Psr\Cache\CacheItemInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

/**
 * Standalone service to manage cache for EsterenMaps.
 * At first it's for Directions, but can be extended to other systems.
 */
class CacheManager
{
    public const CACHE_PREFIX = 'esterenmaps';

    private $cacheAdapter;

    public function __construct(AdapterInterface $cacheAdapter)
    {
        $this->cacheAdapter = $cacheAdapter;
    }

    public function getAdapter(): AdapterInterface
    {
        return $this->cacheAdapter;
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

    public function clear(): void
    {
        $itemsToDelete = [
            static::CACHE_PREFIX.'.api.directions',
            static::CACHE_PREFIX.'.api.maps',
        ];

        $this->cacheAdapter->deleteItems($itemsToDelete);
    }
}
