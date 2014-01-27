<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * EventsRoutes
 *
 * @ORM\Table(name="events_routes")
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\EventsRoutesRepository")
 */
class EventsRoutes {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="routes")
     */
    protected $event;

    /**
     * @var \Routes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Routes", inversedBy="events")
     */
    protected $route;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

	/**
	 * @var smallint
	 *
	 * @ORM\Column(type="smallint", nullable=false)
	 */
	protected $percentage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
     */
    protected $deleted;

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EventsRoutes
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return EventsRoutes
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set percentage
     *
     * @param integer $percentage
     * @return EventsRoutes
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return integer
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set event
     *
     * @param \CorahnRin\MapsBundle\Entity\Events $event
     * @return EventsRoutes
     */
    public function setEvent(\CorahnRin\MapsBundle\Entity\Events $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \CorahnRin\MapsBundle\Entity\Events
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set route
     *
     * @param \CorahnRin\MapsBundle\Entity\Routes $route
     * @return EventsRoutes
     */
    public function setRoute(\CorahnRin\MapsBundle\Entity\Routes $route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return \CorahnRin\MapsBundle\Entity\Routes
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return EventsRoutes
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
