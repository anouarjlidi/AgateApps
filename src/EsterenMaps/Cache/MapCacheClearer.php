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

use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

/**
 * Listener executed on cache:clear command to empty the Directions cache.
 */
class MapCacheClearer implements CacheClearerInterface
{
    /**
 * @var CacheManager
     */
    private $cache;

    public function __construct(CacheManager $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Clears any caches necessary.
     *
     * @param string $cacheDir The cache directory
     */
    public function clear($cacheDir)
    {
        $this->cache->clear();
    }
}
