<?php

namespace EsterenMaps\MapsBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Markers
 *
 * @ORM\Table(name="markers")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\MarkersRepository")
 * @ExclusionPolicy("all")
 */
class Markers
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $altitude;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $latitude;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    protected $longitude;

    /**
     * @var \Datetime
     *
	 * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime
     *
	 * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="markers")
     * @Expose
     */
    protected $faction;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="markers")
     */
    protected $map;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="MarkersTypes", inversedBy="markers")
     * @Expose
     */
    protected $markerType;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="EventsMarkers", mappedBy="marker")
     */
    protected $events;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="markerStart")
     */
    protected $routesStart;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="markerEnd")
     */
    protected $routesEnd;

    public function __toString() {
        return $this->id.' - '.$this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->routes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Markers
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Markers
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Markers
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add routes
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routes
     * @return Markers
     */
    public function addRoute(Routes $routes)
    {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routes
     */
    public function removeRoute(Routes $routes)
    {
        $this->routes->removeElement($routes);
    }

    /**
     * Get routes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Set faction
     *
     * @param \EsterenMaps\MapsBundle\Entity\Factions $faction
     * @return Markers
     */
    public function setFaction(Factions $faction = null)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction
     *
     * @return \EsterenMaps\MapsBundle\Entity\Factions
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set map
     *
     * @param \EsterenMaps\MapsBundle\Entity\Maps $map
     * @return Markers
     */
    public function setMap(Maps $map = null)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return \EsterenMaps\MapsBundle\Entity\Maps
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set markerType
     *
     * @param \EsterenMaps\MapsBundle\Entity\MarkersTypes $markerType
     * @return Markers
     */
    public function setMarkerType(MarkersTypes $markerType = null)
    {
        $this->markerType = $markerType;

        return $this;
    }

    /**
     * Get markerType
     *
     * @return \EsterenMaps\MapsBundle\Entity\MarkersTypes
     */
    public function getMarkerType()
    {
        return $this->markerType;
    }

    /**
     * Add events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsMarkers $events
     * @return Markers
     */
    public function addEvent(EventsMarkers $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsMarkers $events
     */
    public function removeEvent(EventsMarkers $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add routesStart
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routesStart
     * @return Markers
     */
    public function addRoutesStart(Routes $routesStart)
    {
        $this->routesStart[] = $routesStart;

        return $this;
    }

    /**
     * Remove routesStart
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routesStart
     */
    public function removeRoutesStart(Routes $routesStart)
    {
        $this->routesStart->removeElement($routesStart);
    }

    /**
     * Get routesStart
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoutesStart()
    {
        return $this->routesStart;
    }

    /**
     * Get routesStart
     *
     * @return array
     */
    public function getRoutesStartIds()
    {
        $array = array();
        foreach ($this->routesStart as $routeStart) {
            $array[$routeStart->getId()] = $routeStart->getId();
        }
        return $array;
    }

    /**
     * Add routesEnd
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routesEnd
     * @return Markers
     */
    public function addRoutesEnd(Routes $routesEnd)
    {
        $this->routesEnd[] = $routesEnd;

        return $this;
    }

    /**
     * Remove routesEnd
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routesEnd
     */
    public function removeRoutesEnd(Routes $routesEnd)
    {
        $this->routesEnd->removeElement($routesEnd);
    }

    /**
     * Get routesEnd
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoutesEnd()
    {
        return $this->routesEnd;
    }

    /**
     * Get routesEnd
     *
     * @return array
     */
    public function getRoutesEndIds()
    {
        $array = array();
        foreach ($this->routesEnd as $routeEnd) {
            $array[$routeEnd->getId()] = $routeEnd->getId();
        }
        return $array;
    }

    /**
     * Set altitude
     *
     * @param string $altitude
     * @return Markers
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;

        return $this;
    }

    /**
     * Get altitude
     *
     * @return string 
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Markers
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Markers
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
