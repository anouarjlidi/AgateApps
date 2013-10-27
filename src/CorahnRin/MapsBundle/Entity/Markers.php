<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * Markers
 *
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\MarkersRepository")
 */
class Markers
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
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
     * @ORM\ManyToMany(targetEntity="Routes", mappedBy="markers")
     */
    private $routes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="markers")
     */
    private $faction;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="markers")
     */
    private $map;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="MarkersTypes", inversedBy="markers")
     */
    private $markerType;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="EventsMarkers", mappedBy="marker")
     */
    private $events;
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
     * @param \CorahnRin\MapsBundle\Entity\Routes $routes
     * @return Markers
     */
    public function addRoute(\CorahnRin\MapsBundle\Entity\Routes $routes)
    {
        $this->routes[] = $routes;
    
        return $this;
    }

    /**
     * Remove routes
     *
     * @param \CorahnRin\MapsBundle\Entity\Routes $routes
     */
    public function removeRoute(\CorahnRin\MapsBundle\Entity\Routes $routes)
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
     * @param \CorahnRin\MapsBundle\Entity\Factions $faction
     * @return Markers
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
     * Set map
     *
     * @param \CorahnRin\MapsBundle\Entity\Maps $map
     * @return Markers
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
     * Set markerType
     *
     * @param \CorahnRin\MapsBundle\Entity\MarkersTypes $markerType
     * @return Markers
     */
    public function setMarkerType(\CorahnRin\MapsBundle\Entity\MarkersTypes $markerType = null)
    {
        $this->markerType = $markerType;
    
        return $this;
    }

    /**
     * Get markerType
     *
     * @return \CorahnRin\MapsBundle\Entity\MarkersTypes 
     */
    public function getMarkerType()
    {
        return $this->markerType;
    }

    /**
     * Add events
     *
     * @param \CorahnRin\MapsBundle\Entity\EventsMarkers $events
     * @return Markers
     */
    public function addEvent(\CorahnRin\MapsBundle\Entity\EventsMarkers $events)
    {
        $this->events[] = $events;
    
        return $this;
    }

    /**
     * Remove events
     *
     * @param \CorahnRin\MapsBundle\Entity\EventsMarkers $events
     */
    public function removeEvent(\CorahnRin\MapsBundle\Entity\EventsMarkers $events)
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
