<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;

/**
 * Routes
 *
 * @ORM\Table(name="routes")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\RoutesRepository")
 * @ExclusionPolicy("all")
 */
class Routes
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
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
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="routes")
     */
    protected $resources;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
     */
    protected $deleted;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="routesStart")
     * @Expose
     */
    protected $markerStart;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="routesEnd")
     * @Expose
     */
    protected $markerEnd;

    /**
     * @var \Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="routes")
     */
    protected $map;

    /**
     * @var \Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="routes")
     * @Expose
     */
    protected $faction;

    /**
     * @var \RoutesTypes
     *
     * @ORM\ManyToOne(targetEntity="RoutesTypes", inversedBy="routes")
     * @Expose
     */
    protected $routeType;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="EventsRoutes", mappedBy="route")
     */
	protected $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set id
     *
     * @param string $id
     * @return Routes
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Routes
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
     * @return Routes
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
     * @return Routes
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
     * @return Routes
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
     * Add resources
     *
     * @param \EsterenMaps\MapsBundle\Entity\Resources $resources
     * @return Routes
     */
    public function addResource(\EsterenMaps\MapsBundle\Entity\Resources $resources)
    {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources
     *
     * @param \EsterenMaps\MapsBundle\Entity\Resources $resources
     */
    public function removeResource(\EsterenMaps\MapsBundle\Entity\Resources $resources)
    {
        $this->resources->removeElement($resources);
    }

    /**
     * Get resources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Set map
     *
     * @param \EsterenMaps\MapsBundle\Entity\Maps $map
     * @return Routes
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
     * Set faction
     *
     * @param \EsterenMaps\MapsBundle\Entity\Factions $faction
     * @return Routes
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
     * Set routeType
     *
     * @param \EsterenMaps\MapsBundle\Entity\RoutesTypes $routeType
     * @return Routes
     */
    public function setRouteType(\EsterenMaps\MapsBundle\Entity\RoutesTypes $routeType = null)
    {
        $this->routeType = $routeType;

        return $this;
    }

    /**
     * Get routeType
     *
     * @return \EsterenMaps\MapsBundle\Entity\RoutesTypes
     */
    public function getRouteType()
    {
        return $this->routeType;
    }

    /**
     * Add events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsRoutes $events
     * @return Routes
     */
    public function addEvent(\EsterenMaps\MapsBundle\Entity\EventsRoutes $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsRoutes $events
     */
    public function removeEvent(\EsterenMaps\MapsBundle\Entity\EventsRoutes $events)
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
     * @return Routes
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
     * Set markerStart
     *
     * @param \EsterenMaps\MapsBundle\Entity\Markers $markerStart
     * @return Routes
     */
    public function setMarkerStart(\EsterenMaps\MapsBundle\Entity\Markers $markerStart = null)
    {
        $this->markerStart = $markerStart;

        return $this;
    }

    /**
     * Get markerStart
     *
     * @return \EsterenMaps\MapsBundle\Entity\Markers
     */
    public function getMarkerStart()
    {
        return $this->markerStart;
    }

    /**
     * Set markerEnd
     *
     * @param \EsterenMaps\MapsBundle\Entity\Markers $markerEnd
     * @return Routes
     */
    public function setMarkerEnd(\EsterenMaps\MapsBundle\Entity\Markers $markerEnd = null)
    {
        $this->markerEnd = $markerEnd;

        return $this;
    }

    /**
     * Get markerEnd
     *
     * @return \EsterenMaps\MapsBundle\Entity\Markers
     */
    public function getMarkerEnd()
    {
        return $this->markerEnd;
    }
}
