<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Markers.
 *
 * @ORM\Table(schema="maps", name="maps_markers")
 * @ORM\HasLifecycleCallbacks()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\MarkersRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Markers
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     * @Serializer\Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="altitude", type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $altitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $longitude;

    /**
     * @var Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="markers", fetch="EAGER")
     * @ORM\JoinColumn(name="faction_id", nullable=true)
     * @Serializer\Expose
     */
    protected $faction;

    /**
     * @var Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="markers", fetch="EAGER")
     * @ORM\JoinColumn(name="map_id", nullable=false)
     */
    protected $map;

    /**
     * @var MarkersTypes
     *
     * @ORM\ManyToOne(targetEntity="MarkersTypes", inversedBy="markers", fetch="EAGER", fetch="EAGER")
     * @ORM\JoinColumn(name="marker_type_id", nullable=false)
     * @Serializer\Expose
     * @Assert\NotBlank()
     * @Assert\Valid()
     */
    protected $markerType;

    /**
     * @var Routes[]
     *
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="markerStart")
     */
    protected $routesStart;

    /**
     * @var Routes[]
     *
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="markerEnd")
     */
    protected $routesEnd;

    /**
     * @var Routes
     * @Serializer\Expose
     * @Serializer\Type("EsterenMaps\MapsBundle\Entity\Routes")
     */
    public $route = null;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->routes      = new ArrayCollection();
        $this->routesStart = new ArrayCollection();
        $this->routesEnd   = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @param $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add routes.
     *
     * @param Routes $routes
     *
     * @return Markers
     */
    public function addRoute(Routes $routes)
    {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes.
     *
     * @param Routes $routes
     */
    public function removeRoute(Routes $routes)
    {
        $this->routes->removeElement($routes);
    }

    /**
     * Get routes.
     *
     * @return Routes[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Set faction.
     *
     * @param Factions $faction
     *
     * @return Markers
     */
    public function setFaction(Factions $faction = null)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction.
     *
     * @return Factions
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set map.
     *
     * @param Maps $map
     *
     * @return Markers
     */
    public function setMap(Maps $map = null)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map.
     *
     * @return Maps
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set markerType.
     *
     * @param MarkersTypes $markerType
     *
     * @return Markers
     */
    public function setMarkerType(MarkersTypes $markerType = null)
    {
        $this->markerType = $markerType;

        return $this;
    }

    /**
     * Get markerType.
     *
     * @return MarkersTypes
     */
    public function getMarkerType()
    {
        return $this->markerType;
    }

    /**
     * Add routesStart.
     *
     * @param Routes $routesStart
     *
     * @return Markers
     */
    public function addRoutesStart(Routes $routesStart)
    {
        $this->routesStart[] = $routesStart;

        return $this;
    }

    /**
     * Remove routesStart.
     *
     * @param Routes $routesStart
     */
    public function removeRoutesStart(Routes $routesStart)
    {
        $this->routesStart->removeElement($routesStart);
    }

    /**
     * Get routesStart.
     *
     * @return Routes[]
     */
    public function getRoutesStart()
    {
        return $this->routesStart;
    }

    /**
     * Get routesStart.
     *
     * @return array
     */
    public function getRoutesStartIds()
    {
        $array = [];
        foreach ($this->routesStart as $routeStart) {
            $array[$routeStart->getId()] = $routeStart->getId();
        }

        return $array;
    }

    /**
     * Add routesEnd.
     *
     * @param Routes $routesEnd
     *
     * @return Markers
     */
    public function addRoutesEnd(Routes $routesEnd)
    {
        $this->routesEnd[] = $routesEnd;

        return $this;
    }

    /**
     * Remove routesEnd.
     *
     * @param Routes $routesEnd
     */
    public function removeRoutesEnd(Routes $routesEnd)
    {
        $this->routesEnd->removeElement($routesEnd);
    }

    /**
     * Get routesEnd.
     *
     * @return Routes[]
     */
    public function getRoutesEnd()
    {
        return $this->routesEnd;
    }

    /**
     * Get routesEnd.
     *
     * @return array
     */
    public function getRoutesEndIds()
    {
        $array = [];
        foreach ($this->routesEnd as $routeEnd) {
            $array[$routeEnd->getId()] = $routeEnd->getId();
        }

        return $array;
    }

    /**
     * Set altitude.
     *
     * @param string $altitude
     *
     * @return Markers
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;

        return $this;
    }

    /**
     * Get altitude.
     *
     * @return string
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * Set latitude.
     *
     * @param string $latitude
     *
     * @return Markers
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param string $longitude
     *
     * @return Markers
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isLocalized()
    {
        return $this->latitude !== null && $this->longitude !== null;
    }

    public function getWebIcon()
    {
        return $this->markerType->getWebIcon();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateRoutesCoordinates()
    {
        foreach ($this->routesStart as $route) {
            $route->refresh();
        }
        foreach ($this->routesEnd as $route) {
            $route->refresh();
        }
    }
}
