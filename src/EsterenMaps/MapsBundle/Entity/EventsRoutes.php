<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EventsRoutes
 *
 * @ORM\Table(name="events_routes")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\EventsRoutesRepository")
 */
class EventsRoutes {

    /**
     * @var Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="routes")
     */
    protected $event;

    /**
     * @var Routes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Routes", inversedBy="events")
     */
    protected $route;

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
     * @return EventsRoutes
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
     * @return EventsRoutes
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
     * @return EventsRoutes
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
     * @return EventsRoutes
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
     * Set route
     *
     * @param Routes $route
     * @return EventsRoutes
     */
    public function setRoute(Routes $route) {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return Routes
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return EventsRoutes
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
