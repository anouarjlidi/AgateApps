<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * Routes
 *
 * @ORM\Table(name="routes")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\RoutesRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @Serializer\ExclusionPolicy("all")
 */
class Routes {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Serializer\Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Serializer\Expose
     */
    protected $coordinates;

    /**
     * @var integer
     *
     * @ORM\Column(type="float", precision=6, scale=6)
     * @Serializer\Expose
     */
    protected $distance;

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
     * @var Resources
     *
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="routes")
     */
    protected $resources;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * @var Markers
     *
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="routesStart")
     * @Serializer\Expose
     */
    protected $markerStart;

    /**
     * @var Markers
     *
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="routesEnd")
     * @Serializer\Expose
     */
    protected $markerEnd;

    /**
     * @var Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="routes")
     */
    protected $map;

    /**
     * @var Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="routes")
     * @ORM\JoinColumn(nullable=true)
     * @Serializer\Expose
     */
    protected $faction;

    /**
     * @var RoutesTypes
     *
     * @ORM\ManyToOne(targetEntity="RoutesTypes", inversedBy="routes")
     * @Serializer\Expose
     */
    protected $routeType;

    /**
     * @var EventsRoutes[]
     *
     * @ORM\OneToMany(targetEntity="EventsRoutes", mappedBy="route")
     */
    protected $events;

    /**
     * Constructor
     */
    public function __construct() {
        $this->resources = new ArrayCollection();
        $this->events = new ArrayCollection();
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
     * Set id
     *
     * @param string $id
     * @return Routes
     */
    public function setId($id) {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Routes
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
     * Set coordinates
     *
     * @param string $coordinates
     * @return Routes
     */
    public function setCoordinates($coordinates) {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Get coordinates
     *
     * @return string
     */
    public function getCoordinates() {
        return $this->coordinates;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Routes
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
     * @return Routes
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
     * Add resources
     *
     * @param Resources $resources
     * @return Routes
     */
    public function addResource(Resources $resources) {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources
     *
     * @param Resources $resources
     */
    public function removeResource(Resources $resources) {
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
     * Set map
     *
     * @param Maps $map
     * @return Routes
     */
    public function setMap(Maps $map = null) {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return Maps
     */
    public function getMap() {
        return $this->map;
    }

    /**
     * Set faction
     *
     * @param Factions $faction
     * @return Routes
     */
    public function setFaction(Factions $faction = null) {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction
     *
     * @return Factions
     */
    public function getFaction() {
        return $this->faction;
    }

    /**
     * Set routeType
     *
     * @param RoutesTypes $routeType
     * @return Routes
     */
    public function setRouteType(RoutesTypes $routeType = null) {
        $this->routeType = $routeType;

        return $this;
    }

    /**
     * Get routeType
     *
     * @return RoutesTypes
     */
    public function getRouteType() {
        return $this->routeType;
    }

    /**
     * Add events
     *
     * @param EventsRoutes $events
     * @return Routes
     */
    public function addEvent(EventsRoutes $events) {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param EventsRoutes $events
     */
    public function removeEvent(EventsRoutes $events) {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return ArrayCollection
     */
    public function getEvents() {
        return $this->events;
    }

    /**
     * Set markerStart
     *
     * @param Markers $markerStart
     * @return Routes
     */
    public function setMarkerStart(Markers $markerStart = null) {
        $this->markerStart = $markerStart;

        return $this;
    }

    /**
     * Get markerStart
     *
     * @return Markers
     */
    public function getMarkerStart() {
        return $this->markerStart;
    }

    /**
     * Set markerEnd
     *
     * @param Markers $markerEnd
     * @return Routes
     */
    public function setMarkerEnd(Markers $markerEnd = null) {
        $this->markerEnd = $markerEnd;

        return $this;
    }

    /**
     * Get markerEnd
     *
     * @return Markers
     */
    public function getMarkerEnd() {
        return $this->markerEnd;
    }

    /**
     * @return integer
     */
    public function getDistance() {
        return $this->distance;
    }

    /**
     * @param integer $distance
     * @return $this
     */
    public function setDistance($distance) {
        $this->distance = (int) $distance;
        return $this;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return Routes
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

    /**
     * @return array
     */
    public function getDecodedCoordinates()
    {
        return json_decode($this->coordinates, true);
    }

    /**
     * Réinitialise correctement les informations de la route
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @return $this
     */
    public function refresh() {
        $coords = json_decode($this->coordinates, true);

        if ($this->markerStart) {
            $coords[0] = array(
                'lat' => $this->markerStart->getLatitude(),
                'lng' => $this->markerStart->getLongitude(),
            );
        }
        if ($this->markerEnd) {
            $coords[count($coords) - 1] = array(
                'lat' => $this->markerEnd->getLatitude(),
                'lng' => $this->markerEnd->getLongitude(),
            );
        }

        $this->calcDistance();

        $this->setCoordinates(json_encode($coords));

        return $this;
    }

    /**
     * @return integer
     */
    public function calcDistance() {
        $distance = 0;
        $points = json_decode($this->coordinates, true);

        reset($points);

        while ($current = current($points)) {
            $next = next($points);
            if (false !== $next) {
                $currentX = $current['lng'];
                $currentY = $current['lat'];
                $nextX = $next['lng'];
                $nextY = $next['lat'];

                $distance += sqrt(
                    ( $nextX * $nextX )
                    - ( 2 * $currentX * $nextX )
                    + ( $currentX * $currentX )
                    + ( $nextY * $nextY )
                    - ( 2 * $currentY * $nextY )
                    + ( $currentY * $currentY )
                );
            }
        }

        $this->distance = $distance;

        return $distance;
    }
}
