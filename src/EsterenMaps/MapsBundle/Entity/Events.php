<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\EventsRepository")
 */
class Events {

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
     * @var Foes[]
     * @ORM\ManyToMany(targetEntity="Foes", mappedBy="events")
     */
    protected $foes;

    /**
     * @var Npcs[]
     * @ORM\ManyToMany(targetEntity="Npcs", mappedBy="events")
     */
    protected $npcs;

    /**
     * @var Weather[]
     * @ORM\ManyToMany(targetEntity="Weather", mappedBy="events")
     */
    protected $weather;

    /**
     * @var EventsMarkers[]
     * @ORM\OneToMany(targetEntity="EventsMarkers", mappedBy="event")
     */
    protected $markers;

    /**
     * @var EventsMarkersTypes
     * @ORM\OneToMany(targetEntity="EventsMarkersTypes", mappedBy="event")
     */
    protected $markersTypes;

    /**
     * @var EventsResources[]
     * @ORM\OneToMany(targetEntity="EventsResources", mappedBy="event")
     */
    protected $resources;

    /**
     * @var EventsRoutes[]
     * @ORM\OneToMany(targetEntity="EventsRoutes", mappedBy="event")
     */
    protected $routes;

    /**
     * @var EventsRoutesTypes[]
     * @ORM\OneToMany(targetEntity="EventsRoutesTypes", mappedBy="event")
     */
    protected $routesTypes;

    /**
     * @var EventsZonesTypes[]
     * @ORM\OneToMany(targetEntity="EventsZonesTypes", mappedBy="event")
     */
    protected $zonesTypes;

    /**
     * @var EventsZones[]
     * @ORM\OneToMany(targetEntity="EventsZones", mappedBy="event")
     */
    protected $zones;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * Constructor
     */
    public function __construct() {
        $this->foes = new ArrayCollection();
        $this->npcs = new ArrayCollection();
        $this->weather = new ArrayCollection();
        $this->markers = new ArrayCollection();
        $this->markersTypes = new ArrayCollection();
        $this->resources = new ArrayCollection();
        $this->routes = new ArrayCollection();
        $this->routesTypes = new ArrayCollection();
        $this->zones = new ArrayCollection();
        $this->zonesTypes = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Events
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Events
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Events
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Add foes
     *
     * @param Foes $foes
     * @return Events
     */
    public function addFoe(Foes $foes) {
        $this->foes[] = $foes;

        return $this;
    }

    /**
     * Remove foes
     *
     * @param Foes $foes
     */
    public function removeFoe(Foes $foes) {
        $this->foes->removeElement($foes);
    }

    /**
     * Get foes
     *
     * @return ArrayCollection
     */
    public function getFoes() {
        return $this->foes;
    }

    /**
     * Add npcs
     *
     * @param Npcs $npcs
     * @return Events
     */
    public function addNpc(Npcs $npcs) {
        $this->npcs[] = $npcs;

        return $this;
    }

    /**
     * Remove npcs
     *
     * @param Npcs $npcs
     */
    public function removeNpc(Npcs $npcs) {
        $this->npcs->removeElement($npcs);
    }

    /**
     * Get npcs
     *
     * @return ArrayCollection
     */
    public function getNpcs() {
        return $this->npcs;
    }

    /**
     * Add weather
     *
     * @param Weather $weather
     * @return Events
     */
    public function addWeather(Weather $weather) {
        $this->weather[] = $weather;

        return $this;
    }

    /**
     * Remove weather
     *
     * @param Weather $weather
     */
    public function removeWeather(Weather $weather) {
        $this->weather->removeElement($weather);
    }

    /**
     * Get weather
     *
     * @return ArrayCollection
     */
    public function getWeather() {
        return $this->weather;
    }

    /**
     * Add markers
     *
     * @param EventsMarkers $markers
     * @return Events
     */
    public function addMarker(EventsMarkers $markers) {
        $this->markers[] = $markers;

        return $this;
    }

    /**
     * Remove markers
     *
     * @param EventsMarkers $markers
     */
    public function removeMarker(EventsMarkers $markers) {
        $this->markers->removeElement($markers);
    }

    /**
     * Get markers
     *
     * @return ArrayCollection
     */
    public function getMarkers() {
        return $this->markers;
    }

    /**
     * Add markersTypes
     *
     * @param EventsMarkersTypes $markersTypes
     * @return Events
     */
    public function addMarkerType(EventsMarkersTypes $markersTypes) {
        $this->markersTypes[] = $markersTypes;

        return $this;
    }

    /**
     * Remove markersTypes
     *
     * @param EventsMarkersTypes $markersTypes
     */
    public function removeMarkerType(EventsMarkersTypes $markersTypes) {
        $this->markersTypes->removeElement($markersTypes);
    }

    /**
     * Get markersTypes
     *
     * @return ArrayCollection
     */
    public function getMarkersTypes() {
        return $this->markersTypes;
    }

    /**
     * Add resources
     *
     * @param EventsResources $resources
     * @return Events
     */
    public function addResource(EventsResources $resources) {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources
     *
     * @param EventsResources $resources
     */
    public function removeResource(EventsResources $resources) {
        $this->resources->removeElement($resources);
    }

    /**
     * Get resources
     *
     * @return ArrayCollection
     */
    public function getResources() {
        return $this->resources;
    }

    /**
     * Add routes
     *
     * @param EventsRoutes $routes
     * @return Events
     */
    public function addRoute(EventsRoutes $routes) {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes
     *
     * @param EventsRoutes $routes
     */
    public function removeRoute(EventsRoutes $routes) {
        $this->routes->removeElement($routes);
    }

    /**
     * Get routes
     *
     * @return ArrayCollection
     */
    public function getRoutes() {
        return $this->routes;
    }

    /**
     * Add routesTypes
     *
     * @param EventsRoutesTypes $routesTypes
     * @return Events
     */
    public function addRouteType(EventsRoutesTypes $routesTypes) {
        $this->routesTypes[] = $routesTypes;

        return $this;
    }

    /**
     * Remove routesTypes
     *
     * @param EventsRoutesTypes $routesTypes
     */
    public function removeRouteType(EventsRoutesTypes $routesTypes) {
        $this->routesTypes->removeElement($routesTypes);
    }

    /**
     * Get routesTypes
     *
     * @return ArrayCollection
     */
    public function getRoutesTypes() {
        return $this->routesTypes;
    }

    /**
     * Add zonesTypes
     *
     * @param EventsZonesTypes $zonesTypes
     * @return Events
     */
    public function addZoneType(EventsZonesTypes $zonesTypes) {
        $this->zonesTypes[] = $zonesTypes;

        return $this;
    }

    /**
     * Remove zonesTypes
     *
     * @param EventsZonesTypes $zonesTypes
     */
    public function removeZoneType(EventsZonesTypes $zonesTypes) {
        $this->zonesTypes->removeElement($zonesTypes);
    }

    /**
     * Get zonesTypes
     *
     * @return ArrayCollection
     */
    public function getZonesTypes() {
        return $this->zonesTypes;
    }

    /**
     * Add zones
     *
     * @param EventsZones $zones
     * @return Events
     */
    public function addZone(EventsZones $zones) {
        $this->zones[] = $zones;

        return $this;
    }

    /**
     * Remove zones
     *
     * @param EventsZones $zones
     */
    public function removeZone(EventsZones $zones) {
        $this->zones->removeElement($zones);
    }

    /**
     * Get zones
     *
     * @return ArrayCollection
     */
    public function getZones() {
        return $this->zones;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return Events
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted() {
        return $this->deleted;
    }
}
