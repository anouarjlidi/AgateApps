<?php

namespace EsterenMaps\MapsBundle\Services;

/**
 * Class MapsRegistry.
 */
class MapsRegistry
{
    /**
     * @var DirectionsManager
     */
    private $directionsManager;

    /**
     * @var MapImageManager
     */
    private $imageManager;

    /**
     * @var MapsTilesManager
     */
    private $tilesManager;

    /**
     * @var CoordinatesManager
     */
    private $coordinatesManager;

    /**
     * MapsRegistry constructor.
     *
     * @param DirectionsManager  $directionsManager
     * @param MapImageManager    $imageManager
     * @param MapsTilesManager   $tilesManager
     * @param CoordinatesManager $coordinatesManager
     */
    public function __construct(DirectionsManager $directionsManager, MapImageManager $imageManager, MapsTilesManager $tilesManager, CoordinatesManager $coordinatesManager)
    {
        $this->directionsManager  = $directionsManager;
        $this->imageManager       = $imageManager;
        $this->tilesManager       = $tilesManager;
        $this->coordinatesManager = $coordinatesManager;
    }

    /**
     * @return DirectionsManager
     */
    public function getDirectionsManager()
    {
        return $this->directionsManager;
    }

    /**
     * @return MapImageManager
     */
    public function getImageManager()
    {
        return $this->imageManager;
    }

    /**
     * @return MapsTilesManager
     */
    public function getTilesManager()
    {
        return $this->tilesManager;
    }

    /**
     * @return CoordinatesManager
     */
    public function getCoordinatesManager()
    {
        return $this->coordinatesManager;
    }
}
