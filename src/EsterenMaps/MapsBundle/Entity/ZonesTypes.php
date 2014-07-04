<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;

/**
 * ZonesTypes
 *
 * @ORM\Table(name="zones_types")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\ZonesTypesRepository")
 * @ExclusionPolicy("all")
 */
class ZonesTypes {

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
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="zonesTypes")
     */
    protected $resources;

    /**
     * @var Zones[]
     * @ORM\OneToMany(targetEntity="Zones", mappedBy="zoneType")
     */
    protected $zones;

    /**
     * @var EventsZonesTypes[]
     * @ORM\OneToMany(targetEntity="EventsZonesTypes", mappedBy="zoneType")
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
        $this->resources = new ArrayCollection();
        $this->zones = new ArrayCollection();
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
     * @return ZonesTypes
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
     * @return ZonesTypes
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
     * @return ZonesTypes
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
     * @return ZonesTypes
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
     * Add zones
     *
     * @param Zones $zones
     * @return ZonesTypes
     */
    public function addZone(Zones $zones) {
        $this->zones[] = $zones;

        return $this;
    }

    /**
     * Remove zones
     *
     * @param Zones $zones
     */
    public function removeZone(Zones $zones) {
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
     * Add events
     *
     * @param EventsZonesTypes $events
     * @return ZonesTypes
     */
    public function addEvent(EventsZonesTypes $events) {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param EventsZonesTypes $events
     */
    public function removeEvent(EventsZonesTypes $events) {
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
     * @return ZonesTypes
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
