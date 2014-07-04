<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;

/**
 * MarkersType
 *
 * @ORM\Table(name="markers_types")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\MarkersTypesRepository")
 * @ExclusionPolicy("all")
 */
class MarkersTypes {

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
     * @var EventsMarkersTypes[]
     *
     * @ORM\OneToMany(targetEntity="EventsMarkersTypes", mappedBy="markerType")
     */
    protected $events;

    /**
     * @var Markers[]
     *
     * @ORM\OneToMany(targetEntity="Markers", mappedBy="markerType")
     */
    protected $markers;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    public function __toString() {
        return $this->id.' - '.$this->name;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->events = new ArrayCollection();
        $this->markers = new ArrayCollection();
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
     * @return MarkersTypes
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
     * @return MarkersTypes
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
     * @return MarkersTypes
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
     * Add events
     *
     * @param EventsMarkersTypes $events
     * @return MarkersTypes
     */
    public function addEvent(EventsMarkersTypes $events) {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param EventsMarkersTypes $events
     */
    public function removeEvent(EventsMarkersTypes $events) {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return EventsMarkersTypes[]
     */
    public function getEvents() {
        return $this->events;
    }

    /**
     * Add markers
     *
     * @param Markers $markers
     * @return MarkersTypes
     */
    public function addMarker(Markers $markers) {
        $this->markers[] = $markers;

        return $this;
    }

    /**
     * Remove markers
     *
     * @param Markers $markers
     */
    public function removeMarker(Markers $markers) {
        $this->markers->removeElement($markers);
    }

    /**
     * Get markers
     *
     * @return Markers[]
     */
    public function getMarkers() {
        return $this->markers;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return MarkersTypes
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
