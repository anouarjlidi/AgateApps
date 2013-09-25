<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * Routes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\RoutesRepository")
 */
class Routes
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $coordinates;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="routes")
     */
    private $resources;

	
	
    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Markers", inversedBy="routes")
     */
    private $markers;

    /**
     * @var \Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="routes")
     */
    private $map;

    /**
     * @var \Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="routes")
     */
    private $faction;

    /**
     * @var \RoutesTypes
     *
     * @ORM\ManyToOne(targetEntity="RoutesTypes", inversedBy="routes")
     */
    private $routeType;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="EventsRoutes", mappedBy="route")
     */
	private $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->markers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \CorahnRin\MapsBundle\Entity\Resources $resources
     * @return Routes
     */
    public function addResource(\CorahnRin\MapsBundle\Entity\Resources $resources)
    {
        $this->resources[] = $resources;
    
        return $this;
    }

    /**
     * Remove resources
     *
     * @param \CorahnRin\MapsBundle\Entity\Resources $resources
     */
    public function removeResource(\CorahnRin\MapsBundle\Entity\Resources $resources)
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
     * Add markers
     *
     * @param \CorahnRin\MapsBundle\Entity\Markers $markers
     * @return Routes
     */
    public function addMarker(\CorahnRin\MapsBundle\Entity\Markers $markers)
    {
        $this->markers[] = $markers;
    
        return $this;
    }

    /**
     * Remove markers
     *
     * @param \CorahnRin\MapsBundle\Entity\Markers $markers
     */
    public function removeMarker(\CorahnRin\MapsBundle\Entity\Markers $markers)
    {
        $this->markers->removeElement($markers);
    }

    /**
     * Get markers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * Set map
     *
     * @param \CorahnRin\MapsBundle\Entity\Maps $map
     * @return Routes
     */
    public function setMap(\CorahnRin\MapsBundle\Entity\Maps $map = null)
    {
        $this->map = $map;
    
        return $this;
    }

    /**
     * Get map
     *
     * @return \CorahnRin\MapsBundle\Entity\Maps 
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set faction
     *
     * @param \CorahnRin\MapsBundle\Entity\Factions $faction
     * @return Routes
     */
    public function setFaction(\CorahnRin\MapsBundle\Entity\Factions $faction = null)
    {
        $this->faction = $faction;
    
        return $this;
    }

    /**
     * Get faction
     *
     * @return \CorahnRin\MapsBundle\Entity\Factions 
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set routeType
     *
     * @param \CorahnRin\MapsBundle\Entity\RoutesTypes $routeType
     * @return Routes
     */
    public function setRouteType(\CorahnRin\MapsBundle\Entity\RoutesTypes $routeType = null)
    {
        $this->routeType = $routeType;
    
        return $this;
    }

    /**
     * Get routeType
     *
     * @return \CorahnRin\MapsBundle\Entity\RoutesTypes 
     */
    public function getRouteType()
    {
        return $this->routeType;
    }

    /**
     * Add events
     *
     * @param \CorahnRin\MapsBundle\Entity\EventsRoutes $events
     * @return Routes
     */
    public function addEvent(\CorahnRin\MapsBundle\Entity\EventsRoutes $events)
    {
        $this->events[] = $events;
    
        return $this;
    }

    /**
     * Remove events
     *
     * @param \CorahnRin\MapsBundle\Entity\EventsRoutes $events
     */
    public function removeEvent(\CorahnRin\MapsBundle\Entity\EventsRoutes $events)
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
}