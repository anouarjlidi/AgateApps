<?php

namespace EsterenMaps\MapsBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\EventsRepository")
 */
class Events
{
    /**
     * @var integer
	 *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var \Datetime
	 * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime
	 * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var DoctrineCollection
     * @ORM\ManyToMany(targetEntity="Foes", mappedBy="events")
     */
    protected $foes;

    /**
     * @var DoctrineCollection
     * @ORM\ManyToMany(targetEntity="Npcs", mappedBy="events")
     */
    protected $npcs;

    /**
     * @var DoctrineCollection
     * @ORM\ManyToMany(targetEntity="Weather", mappedBy="events")
     */
    protected $weather;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsMarkers", mappedBy="event")
     */
    protected $markers;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsMarkersTypes", mappedBy="event")
     */
    protected $markersTypes;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsResources", mappedBy="event")
     */
    protected $resources;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsRoutes", mappedBy="event")
     */
    protected $routes;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsRoutesTypes", mappedBy="event")
     */
    protected $routesTypes;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsZones", mappedBy="event")
     */
    protected $zones;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->foes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->npcs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->weather = new \Doctrine\Common\Collections\ArrayCollection();
        $this->markers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->markersTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routesTypes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set created
     *
     * @param \DateTime $created
     * @return Events
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
     * @return Events
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
     * Add foes
     *
     * @param \EsterenMaps\MapsBundle\Entity\Foes $foes
     * @return Events
     */
    public function addFo(\EsterenMaps\MapsBundle\Entity\Foes $foes)
    {
        $this->foes[] = $foes;

        return $this;
    }

    /**
     * Remove foes
     *
     * @param \EsterenMaps\MapsBundle\Entity\Foes $foes
     */
    public function removeFo(\EsterenMaps\MapsBundle\Entity\Foes $foes)
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
     * Add npcs
     *
     * @param \EsterenMaps\MapsBundle\Entity\Npcs $npcs
     * @return Events
     */
    public function addNpc(\EsterenMaps\MapsBundle\Entity\Npcs $npcs)
    {
        $this->npcs[] = $npcs;

        return $this;
    }

    /**
     * Remove npcs
     *
     * @param \EsterenMaps\MapsBundle\Entity\Npcs $npcs
     */
    public function removeNpc(\EsterenMaps\MapsBundle\Entity\Npcs $npcs)
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
     * Add weather
     *
     * @param \EsterenMaps\MapsBundle\Entity\Weather $weather
     * @return Events
     */
    public function addWeather(\EsterenMaps\MapsBundle\Entity\Weather $weather)
    {
        $this->weather[] = $weather;

        return $this;
    }

    /**
     * Remove weather
     *
     * @param \EsterenMaps\MapsBundle\Entity\Weather $weather
     */
    public function removeWeather(\EsterenMaps\MapsBundle\Entity\Weather $weather)
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
     * Add markers
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsMarkers $markers
     * @return Events
     */
    public function addMarker(\EsterenMaps\MapsBundle\Entity\EventsMarkers $markers)
    {
        $this->markers[] = $markers;

        return $this;
    }

    /**
     * Remove markers
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsMarkers $markers
     */
    public function removeMarker(\EsterenMaps\MapsBundle\Entity\EventsMarkers $markers)
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
     * Add markersTypes
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsMarkersTypes $markersTypes
     * @return Events
     */
    public function addMarkersType(\EsterenMaps\MapsBundle\Entity\EventsMarkersTypes $markersTypes)
    {
        $this->markersTypes[] = $markersTypes;

        return $this;
    }

    /**
     * Remove markersTypes
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsMarkersTypes $markersTypes
     */
    public function removeMarkersType(\EsterenMaps\MapsBundle\Entity\EventsMarkersTypes $markersTypes)
    {
        $this->markersTypes->removeElement($markersTypes);
    }

    /**
     * Get markersTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMarkersTypes()
    {
        return $this->markersTypes;
    }

    /**
     * Add resources
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsResources $resources
     * @return Events
     */
    public function addResource(\EsterenMaps\MapsBundle\Entity\EventsResources $resources)
    {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsResources $resources
     */
    public function removeResource(\EsterenMaps\MapsBundle\Entity\EventsResources $resources)
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
     * @param \EsterenMaps\MapsBundle\Entity\EventsRoutes $routes
     * @return Events
     */
    public function addRoute(\EsterenMaps\MapsBundle\Entity\EventsRoutes $routes)
    {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsRoutes $routes
     */
    public function removeRoute(\EsterenMaps\MapsBundle\Entity\EventsRoutes $routes)
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
     * @param \EsterenMaps\MapsBundle\Entity\EventsRoutesTypes $routesTypes
     * @return Events
     */
    public function addRoutesType(\EsterenMaps\MapsBundle\Entity\EventsRoutesTypes $routesTypes)
    {
        $this->routesTypes[] = $routesTypes;

        return $this;
    }

    /**
     * Remove routesTypes
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsRoutesTypes $routesTypes
     */
    public function removeRoutesType(\EsterenMaps\MapsBundle\Entity\EventsRoutesTypes $routesTypes)
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
     * Add zones
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsZones $zones
     * @return Events
     */
    public function addZone(\EsterenMaps\MapsBundle\Entity\EventsZones $zones)
    {
        $this->zones[] = $zones;

        return $this;
    }

    /**
     * Remove zones
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsZones $zones
     */
    public function removeZone(\EsterenMaps\MapsBundle\Entity\EventsZones $zones)
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
