<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EventsMarkers
 *
 * @ORM\Table(name="events_markers")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\EventsMarkersRepository")
 */
class EventsMarkers {

    /**
     * @var Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="markers")
     */
    protected $event;

    /**
     * @var Markers
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="events")
     */
    protected $marker;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $percentage;

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
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * Set percentage
     *
     * @param integer $percentage
     * @return EventsMarkers
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
     * Set created
     *
     * @param \DateTime $created
     * @return EventsMarkers
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
     * @return EventsMarkers
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
     * Set event
     *
     * @param Events $event
     * @return EventsMarkers
     */
    public function setEvent(Events $event) {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return Events
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * Set marker
     *
     * @param Markers $marker
     * @return EventsMarkers
     */
    public function setMarker(Markers $marker) {
        $this->marker = $marker;

        return $this;
    }

    /**
     * Get marker
     *
     * @return Markers
     */
    public function getMarker() {
        return $this->marker;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return EventsMarkers
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
