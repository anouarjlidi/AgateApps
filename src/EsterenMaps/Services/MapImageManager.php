<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\Services;

use EsterenMaps\Entity\Maps;

class MapImageManager
{
    private $webDir;

    public function __construct(string $publicDir)
    {
        $this->webDir = $publicDir;
    }

    /**
     * @param Maps $map
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getImagePath(Maps $map)
    {
        $ext = \pathinfo($map->getImage(), PATHINFO_EXTENSION);

        if (!$ext) {
            throw new \RuntimeException('Could not get map image extension. Got "'.$map->getImage().'".');
        }

        $path = \preg_replace('~\.'.$ext.'$~i', '_IM.'.$ext, $map->getImage());

        return $this->webDir.'/'.$path;
    }

    /**
     * @param Maps $map
     *
     * @throws \RuntimeException
     */
    public function generateImage(Maps $map)
    {
        // TODO
        throw new \RuntimeException('Not implemented yet');
    }
}
