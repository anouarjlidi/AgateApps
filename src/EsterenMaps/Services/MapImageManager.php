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
use Symfony\Component\HttpKernel\KernelInterface;

class MapImageManager
{
    private $webDir;
    private $magickPath;
    private $outputDirectory;

    public function __construct(string $outputDirectory, string $imageMagickPath, KernelInterface $kernel)
    {
        $outputDirectory  = rtrim($outputDirectory, '\\/');
        $this->magickPath = rtrim($imageMagickPath, '\\/').DIRECTORY_SEPARATOR;
        if (strpos($outputDirectory, '@') === 0) {
            $this->outputDirectory = $kernel->locateResource($outputDirectory);
        } else {
            $this->outputDirectory = $outputDirectory;
        }
        $this->webDir = $kernel->getRootDir().'/../public';
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
        $ext = pathinfo($map->getImage(), PATHINFO_EXTENSION);

        if (!$ext) {
            throw new \RuntimeException('Could not get map image extension. Got "'.$map->getImage().'".');
        }

        $path = preg_replace('~\.'.$ext.'$~i', '_IM.'.$ext, $map->getImage());

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
