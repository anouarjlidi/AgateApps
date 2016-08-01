<?php

namespace EsterenMaps\MapsBundle\Cache;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\CacheItem;

/**
 * Standalone service to manage cache for EsterenMaps.
 * At first it's for Directions, but can be extended to other systems.
 */
class CacheManager
{
    const CACHE_NAME = 'esterenmaps';

    /**
     * In seconds, how much time will the cache be saved in cache service.
     *
     * @var int
     */
    private $cacheTTL;

    /**
     * @var AdapterInterface
     */
    private $cacheAdapter;

    /**
     * @param int           $cacheTTL
     * @param AdapterInterface  $cacheAdapter
     */
    public function __construct($cacheTTL, AdapterInterface $cacheAdapter)
    {
        $this->cacheTTL      = $cacheTTL;
        $this->cacheAdapter  = $cacheAdapter;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->cacheAdapter;
    }

    /**
     * @return CacheItem|null
     */
    public function getCacheItem()
    {
        return $this->cacheAdapter->getItem(static::CACHE_NAME);
    }

    /**
     * @param CacheItem $cacheItem
     * @param string    $hash
     *
     * @return null|string
     */
    public function getItemValue(CacheItem $cacheItem, $hash)
    {
        $cacheValue = $cacheItem->isHit() ? $cacheItem->get() : null;

        return $cacheValue && is_array($cacheValue) && isset($cacheValue[$hash])
            ? $cacheValue[$hash]
            : null;
    }

    /**
     * @param string $hash
     * @param string $value
     *
     * @return array|\Generator|null|\Traversable
     */
    public function save($hash, $value)
    {
        $expirationDate = new \DateTime();
        $expirationDate->setTimestamp(time() + $this->cacheTTL);

        $item = $this->getCacheItem();

        // Update expiration date
        $item->expiresAt($expirationDate);

        $cacheArray = $item->get() ?: [];
        if (!is_array($cacheArray)) {
            // Force cache corruption solve.
            $cacheArray = [];
        }
        $cacheArray[$hash] = $value;

        $item->set($cacheArray);

        $this->cacheAdapter->save($item);
    }
}
