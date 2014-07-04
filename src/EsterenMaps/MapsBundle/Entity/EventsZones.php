<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EventsZones
 *
 * @ORM\Table(name="events_zones")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\EventsZonesRepository")
 */
class EventsZones {

    /**
     * @var Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="zones")
     */
    protected $event;

    /**
     * @var Zones
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Zones", inversedBy="events")
     */
    protected $zone;

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
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $percentage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * Set event
     *
     * @param integer $event
     * @return EventsZones
     */
    public function setEvent($event) {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return integer
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EventsZones
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
     * @return EventsZones
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
     * Set percentage
     *
     * @param integer $percentage
     * @return EventsZones
     */
    public function setPercentage($percentage) {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return integer
     */
    public function getPercentage() {
        return $this->percentage;
    }

    /**
     * Set zone
     *
     * @param Zones $zone
     * @return EventsZones
     */
    public function setZone(Zones $zone) {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get zone
     *
     * @return Zones
     */
    public function getZone() {
        return $this->zone;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return EventsZones
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
