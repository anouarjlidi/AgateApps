<?php

namespace EsterenMaps\MapsBundle\Services;

use Exception;
use Doctrine\ORM\EntityManager;
use EsterenMaps\MapsBundle\Entity\Maps;
use Symfony\Component\HttpKernel\KernelInterface;

class MapImageManager
{

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var string
     */
    private $webDir;

    /**
     * @var EntityManager
     */
    private $em;

    function __construct($outputDirectory, $imageMagickPath, EntityManager $em, KernelInterface $kernel)
    {
        $outputDirectory = rtrim($outputDirectory, '\\/');
        $this->magickPath = rtrim($imageMagickPath, '\\/').DIRECTORY_SEPARATOR;
        if (strpos($outputDirectory, '@') === 0) {
            $this->outputDirectory = $kernel->locateResource($outputDirectory);
        } else {
            $this->outputDirectory = $outputDirectory;
        }
        $this->webDir = $kernel->getRootDir().'/../web';
        $this->debug = $kernel->isDebug();
        $this->em = $em;
    }

    /**
     * @param Maps $map
     *
     * @return string
     * @throws Exception
     */
    public function getImagePath(Maps $map)
    {
        $ext = pathinfo($map->getImage(), PATHINFO_EXTENSION);

        if (!$ext) {
            throw new Exception('Could not get map image extension. Got "'.$map->getImage().'".');
        }

        $path = preg_replace('~\.'.$ext.'$~i', '_IM.'.$ext, $map->getImage());

        return $this->webDir.'/'.$path;
    }

    /**
     * @param Maps $map
     *
     * @throws Exception
     */
    public function generateImage(Maps $map)
    {
        //
        throw new Exception($map);
    }
}
