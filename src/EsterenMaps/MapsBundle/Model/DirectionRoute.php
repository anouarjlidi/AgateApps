<?php

namespace EsterenMaps\MapsBundle\Model;

final class DirectionRoute
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $distance;

    /**
     * @var float
     */
    private $forcedDistance;

    /**
     * @var string
     */
    private $coordinates;

    /**
     * @var bool
     */
    private $guarded;

    /**
     * @var int
     */
    private $markerStartId;

    /**
     * @var string
     */
    private $markerStartName;

    /**
     * @var int
     */
    private $markerEndId;

    /**
     * @var string
     */
    private $markerEndName;

    /**
     * @var int
     */
    private $routeTypeId;

    /**
     * @var string
     */
    private $routeTypeName;

    /**
     * @var DirectionRouteTransport[]
     */
    private $transports;

    /**
     * @param int    $id
     * @param string $name
     * @param float  $distance
     * @param float  $forcedDistance
     * @param string $coordinates
     * @param bool   $guarded
     * @param int    $markerStartId
     * @param string $markerStartName
     * @param int    $markerEndId
     * @param string $markerEndName
     * @param int    $routeTypeId
     * @param string $routeTypeName
     * @param array  $transports
     */
    public function __construct($id, $name, $distance, $forcedDistance, $coordinates, $guarded, $markerStartId, $markerStartName, $markerEndId, $markerEndName, $routeTypeId, $routeTypeName, array $transports = [])
    {
        $this->id              = (int) $id;
        $this->name            = (string) $name;
        $this->distance        = (float) $distance;
        $this->forcedDistance  = (float) $forcedDistance;
        $this->coordinates     = (string) $coordinates;
        $this->guarded         = (bool) $guarded;
        $this->markerStartId   = (int) $markerStartId;
        $this->markerStartName = (string) $markerStartName;
        $this->markerEndId     = (int) $markerEndId;
        $this->markerEndName   = (string) $markerEndName;
        $this->routeTypeId     = (int) $routeTypeId;
        $this->routeTypeName   = (string) $routeTypeName;
        $this->transports      = $transports;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @return float
     */
    public function getForcedDistance()
    {
        return $this->forcedDistance;
    }

    /**
     * @return string
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * @return boolean
     */
    public function isGuarded()
    {
        return $this->guarded;
    }

    /**
     * @return int
     */
    public function getMarkerStartId()
    {
        return $this->markerStartId;
    }

    /**
     * @return string
     */
    public function getMarkerStartName()
    {
        return $this->markerStartName;
    }

    /**
     * @return int
     */
    public function getMarkerEndId()
    {
        return $this->markerEndId;
    }

    /**
     * @return string
     */
    public function getMarkerEndName()
    {
        return $this->markerEndName;
    }

    /**
     * @return int
     */
    public function getRouteTypeId()
    {
        return $this->routeTypeId;
    }

    /**
     * @return string
     */
    public function getRouteTypeName()
    {
        return $this->routeTypeName;
    }

    /**
     * @return DirectionRouteTransport[]
     */
    public function getTransports()
    {
        return $this->transports;
    }

    /**
     * @param DirectionRouteTransport $transport
     */
    public function addTransport(DirectionRouteTransport $transport)
    {
        $this->transports[] = $transport;
    }
}
