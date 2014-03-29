<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;

/**
 * Markers
 *
 * @ORM\Table(name="markers")
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
     * @ORM\Column(type="text")
     * @Expose
     */
    protected $coordinates;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="update")
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
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
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
     * Set coordinates
     *
     * @param string $coordinates
     * @return Markers
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Get coordinates
     *
     * @return string
     */
    public function getCoordinates()
    {
        return $this->coordinates;
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
    public function addRoute(\EsterenMaps\MapsBundle\Entity\Routes $routes)
    {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routes
     */
    public function removeRoute(\EsterenMaps\MapsBundle\Entity\Routes $routes)
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
    public function setFaction(\EsterenMaps\MapsBundle\Entity\Factions $faction = null)
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
    public function setMap(\EsterenMaps\MapsBundle\Entity\Maps $map = null)
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
    public function setMarkerType(\EsterenMaps\MapsBundle\Entity\MarkersTypes $markerType = null)
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
    public function addEvent(\EsterenMaps\MapsBundle\Entity\EventsMarkers $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsMarkers $events
     */
    public function removeEvent(\EsterenMaps\MapsBundle\Entity\EventsMarkers $events)
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
     * Set deleted
     *
     * @param boolean $deleted
     * @return Markers
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Add routesStart
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routesStart
     * @return Markers
     */
    public function addRoutesStart(\EsterenMaps\MapsBundle\Entity\Routes $routesStart)
    {
        $this->routesStart[] = $routesStart;

        return $this;
    }

    /**
     * Remove routesStart
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routesStart
     */
    public function removeRoutesStart(\EsterenMaps\MapsBundle\Entity\Routes $routesStart)
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
    public function addRoutesEnd(\EsterenMaps\MapsBundle\Entity\Routes $routesEnd)
    {
        $this->routesEnd[] = $routesEnd;

        return $this;
    }

    /**
     * Remove routesEnd
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routesEnd
     */
    public function removeRoutesEnd(\EsterenMaps\MapsBundle\Entity\Routes $routesEnd)
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
}
