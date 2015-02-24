<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;

/**
 * RoutesTypes
 *
 * @ORM\Table(name="maps_routes_types")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 * @ExclusionPolicy("all")
 */
class RoutesTypes {

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
     * @ORM\Column(type="text", nullable=true)
     * @Expose
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=75, nullable=true)
     * @Expose
     */
    protected $color;

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
     * @var Resources[]
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="routesTypes")
     */
    protected $resources;

    /**
     * @var Routes[]
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="routeType")
     */
    protected $routes;

    /**
     * @var EventsRoutesTypes[]
     * @ORM\OneToMany(targetEntity="EventsRoutesTypes", mappedBy="routeType")
     */
    protected $events;

    /**
     * @var RoutesTransports
     * @ORM\OneToMany(targetEntity="EsterenMaps\MapsBundle\Entity\RoutesTransports", mappedBy="routeType")
     */
    protected $transports;

    /**
     * @var integer
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->resources = new ArrayCollection();
        $this->routes = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->transports = new ArrayCollection();
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
     * @param integer $id
     * @return $this
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
     * @return RoutesTypes
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
     * @return RoutesTypes
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
     * @return RoutesTypes
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
     * @return RoutesTypes
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
     * Add routes
     *
     * @param Routes $routes
     * @return RoutesTypes
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
     * Add events
     *
     * @param EventsRoutesTypes $events
     * @return RoutesTypes
     */
    public function addEvent(EventsRoutesTypes $events) {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param EventsRoutesTypes $events
     */
    public function removeEvent(EventsRoutesTypes $events) {
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
     * @return RoutesTypes
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
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return RoutesTypes
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return RoutesTypes
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Add transports
     *
     * @param RoutesTransports $transports
     * @return RoutesTypes
     */
    public function addTransport(RoutesTransports $transports) {
        $this->transports[] = $transports;

        return $this;
    }

    /**
     * Remove transports
     *
     * @param RoutesTransports $transports
     */
    public function removeTransport(RoutesTransports $transports) {
        $this->transports->removeElement($transports);
    }

    /**
     * Get transports
     *
     * @return ArrayCollection
     */
    public function getTransports() {
        return $this->transports;
    }

}
