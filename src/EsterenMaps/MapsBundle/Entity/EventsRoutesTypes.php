<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EventsRoutesTypes
 *
 * @ORM\Table(name="events_routes_types")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\EventsRoutesTypesRepository")
 */
class EventsRoutesTypes {

    /**
     * @var Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="routesTypes")
     */
    protected $event;

    /**
     * @var RoutesTypes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="RoutesTypes", inversedBy="events")
     */
    protected $routeType;

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
     * Set created
     *
     * @param \DateTime $created
     * @return EventsRoutesTypes
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
     * @return EventsRoutesTypes
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
     * @return EventsRoutesTypes
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
     * Set event
     *
     * @param Events $event
     * @return EventsRoutesTypes
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
     * Set routeType
     *
     * @param RoutesTypes $routeType
     * @return EventsRoutesTypes
     */
    public function setRouteType(RoutesTypes $routeType) {
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
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return EventsRoutesTypes
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
