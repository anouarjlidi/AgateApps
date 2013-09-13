<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity
 */
class Events
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    private $dateModified;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Foes", mappedBy="events")
     */
    private $foes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="MarkersType", mappedBy="events")
     */
    private $markersType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Markers", mappedBy="events")
     */
    private $markers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Npcs", mappedBy="events")
     */
    private $npcs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="events")
     */
    private $resources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Routes", mappedBy="events")
     */
    private $routes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="RoutesTypes", mappedBy="events")
     */
    private $routesTypes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Weather", inversedBy="events")
     * @ORM\JoinTable(name="event_weather",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_events", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_weather", referencedColumnName="id")
     *   }
     * )
     */
    private $weather;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Zones", mappedBy="events")
     */
    private $zones;
	
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->foes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->markersType = new \Doctrine\Common\Collections\ArrayCollection();
        $this->markers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->npcs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routesTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->weather = new \Doctrine\Common\Collections\ArrayCollection();
        $this->zones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Events
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Events
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return Events
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;
    
        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Add foes
     *
     * @param \CorahnRin\MapsBundle\Entity\Foes $foes
     * @return Events
     */
    public function addFoe(\CorahnRin\MapsBundle\Entity\Foes $foes)
    {
        $this->foes[] = $foes;
    
        return $this;
    }

    /**
     * Remove foes
     *
     * @param \CorahnRin\MapsBundle\Entity\Foes $foes
     */
    public function removeFoe(\CorahnRin\MapsBundle\Entity\Foes $foes)
    {
        $this->foes->removeElement($foes);
    }

    /**
     * Get foes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFoes()
    {
        return $this->foes;
    }

    /**
     * Add markersType
     *
     * @param \CorahnRin\MapsBundle\Entity\MarkersType $markersType
     * @return Events
     */
    public function addMarkersType(\CorahnRin\MapsBundle\Entity\MarkersType $markersType)
    {
        $this->markersType[] = $markersType;
    
        return $this;
    }

    /**
     * Remove markersType
     *
     * @param \CorahnRin\MapsBundle\Entity\MarkersType $markersType
     */
    public function removeMarkersType(\CorahnRin\MapsBundle\Entity\MarkersType $markersType)
    {
        $this->markersType->removeElement($markersType);
    }

    /**
     * Get markersType
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMarkersType()
    {
        return $this->markersType;
    }

    /**
     * Add markers
     *
     * @param \CorahnRin\MapsBundle\Entity\Markers $markers
     * @return Events
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
     * Add npcs
     *
     * @param \CorahnRin\MapsBundle\Entity\Npcs $npcs
     * @return Events
     */
    public function addNpc(\CorahnRin\MapsBundle\Entity\Npcs $npcs)
    {
        $this->npcs[] = $npcs;
    
        return $this;
    }

    /**
     * Remove npcs
     *
     * @param \CorahnRin\MapsBundle\Entity\Npcs $npcs
     */
    public function removeNpc(\CorahnRin\MapsBundle\Entity\Npcs $npcs)
    {
        $this->npcs->removeElement($npcs);
    }

    /**
     * Get npcs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNpcs()
    {
        return $this->npcs;
    }

    /**
     * Add resources
     *
     * @param \CorahnRin\MapsBundle\Entity\Resources $resources
     * @return Events
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
     * Add routes
     *
     * @param \CorahnRin\MapsBundle\Entity\Routes $routes
     * @return Events
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
     * Add routesTypes
     *
     * @param \CorahnRin\MapsBundle\Entity\RoutesTypes $routesTypes
     * @return Events
     */
    public function addRoutesType(\CorahnRin\MapsBundle\Entity\RoutesTypes $routesTypes)
    {
        $this->routesTypes[] = $routesTypes;
    
        return $this;
    }

    /**
     * Remove routesTypes
     *
     * @param \CorahnRin\MapsBundle\Entity\RoutesTypes $routesTypes
     */
    public function removeRoutesType(\CorahnRin\MapsBundle\Entity\RoutesTypes $routesTypes)
    {
        $this->routesTypes->removeElement($routesTypes);
    }

    /**
     * Get routesTypes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoutesTypes()
    {
        return $this->routesTypes;
    }

    /**
     * Add weather
     *
     * @param \CorahnRin\MapsBundle\Entity\Weather $weather
     * @return Events
     */
    public function addWeather(\CorahnRin\MapsBundle\Entity\Weather $weather)
    {
        $this->weather[] = $weather;
    
        return $this;
    }

    /**
     * Remove weather
     *
     * @param \CorahnRin\MapsBundle\Entity\Weather $weather
     */
    public function removeWeather(\CorahnRin\MapsBundle\Entity\Weather $weather)
    {
        $this->weather->removeElement($weather);
    }

    /**
     * Get weather
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWeather()
    {
        return $this->weather;
    }

    /**
     * Add zones
     *
     * @param \CorahnRin\MapsBundle\Entity\Zones $zones
     * @return Events
     */
    public function addZone(\CorahnRin\MapsBundle\Entity\Zones $zones)
    {
        $this->zones[] = $zones;
    
        return $this;
    }

    /**
     * Remove zones
     *
     * @param \CorahnRin\MapsBundle\Entity\Zones $zones
     */
    public function removeZone(\CorahnRin\MapsBundle\Entity\Zones $zones)
    {
        $this->zones->removeElement($zones);
    }

    /**
     * Get zones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getZones()
    {
        return $this->zones;
    }
}