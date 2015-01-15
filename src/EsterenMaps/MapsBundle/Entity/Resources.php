<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Resources
 *
 * @ORM\Table(name="resources")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 */
class Resources {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    protected $name;

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
     * @var Routes[]
     * @ORM\ManyToMany(targetEntity="Routes", inversedBy="resources")
     */
    protected $routes;

    /**
     * @var RoutesTypes[]
     * @ORM\ManyToMany(targetEntity="RoutesTypes", inversedBy="resources")
     */
    protected $routesTypes;

    /**
     * @var ZonesTypes[]
     * @ORM\ManyToMany(targetEntity="ZonesTypes", inversedBy="resources")
     */
    protected $zonesTypes;

    /**
     * @var EventsResources[]
     * @ORM\OneToMany(targetEntity="EventsResources", mappedBy="resource")
     */
    protected $events;

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
        $this->routes = new ArrayCollection();
        $this->routesTypes = new ArrayCollection();
        $this->zonesTypes = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Resources
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
     * @return Resources
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
     * @return Resources
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
     * Add routes
     *
     * @param Routes $routes
     * @return Resources
     */
    public function addRoute(Routes $routes) {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes
     *
     * @param Routes $routes
     */
    public function removeRoute(Routes $routes) {
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
     * @param RoutesTypes $routesTypes
     * @return Resources
     */
    public function addRouteType(RoutesTypes $routesTypes) {
        $this->routesTypes[] = $routesTypes;

        return $this;
    }

    /**
     * Remove routesTypes
     *
     * @param RoutesTypes $routesTypes
     */
    public function removeRouteType(RoutesTypes $routesTypes) {
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
     * Add events
     *
     * @param EventsResources $events
     * @return Resources
     */
    public function addEvent(EventsResources $events) {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param EventsResources $events
     */
    public function removeEvent(EventsResources $events) {
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
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return Resources
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
     * Add zonesTypes
     *
     * @param \EsterenMaps\MapsBundle\Entity\ZonesTypes $zonesTypes
     * @return Resources
     */
    public function addZoneType(\EsterenMaps\MapsBundle\Entity\ZonesTypes $zonesTypes) {
        $this->zonesTypes[] = $zonesTypes;

        return $this;
    }

    /**
     * Remove zonesTypes
     *
     * @param \EsterenMaps\MapsBundle\Entity\ZonesTypes $zonesTypes
     */
    public function removeZoneType(\EsterenMaps\MapsBundle\Entity\ZonesTypes $zonesTypes) {
        $this->zonesTypes->removeElement($zonesTypes);
    }

    /**
     * Get zonesTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZonesTypes() {
        return $this->zonesTypes;
    }
}
