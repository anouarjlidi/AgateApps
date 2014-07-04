<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * EventsResources
 *
 * @ORM\Table(name="events_resources")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\EventsResourcesRepository")
 */
class EventsResources {

    /**
     * @var Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="resources")
     */
    protected $event;

    /**
     * @var Resources
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Resources", inversedBy="events")
     */
    protected $resource;

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
     * @return EventsResources
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
     * @return EventsResources
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
     * @return EventsResources
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
     * @return EventsResources
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
     * Set resource
     *
     * @param Resources $resource
     * @return EventsResources
     */
    public function setResource(Resources $resource) {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return Resources
     */
    public function getResource() {
        return $this->resource;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return EventsResources
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
