<?php
/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Cache;

use Symfony\Component\HttpKernel\CacheClearer\CacheClearerInterface;

class DirectionsCacheClearer implements CacheClearerInterface
{
    /**
     * @var CacheManager
     */
    private $cache;

    /**
     * DirectionsCacheClearer constructor.
     */
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
        $this->cache->getAdapter()->deleteItem(CacheManager::CACHE_NAME);
    }
}
