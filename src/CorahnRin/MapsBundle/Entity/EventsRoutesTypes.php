<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * EventsRoutesTypes
 *
 * @ORM\Table(name="events_routes_types")
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\EventsRoutesTypesRepository")
 */
class EventsRoutesTypes {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="routesTypes")
     */
    protected $event;

    /**
     * @var \RoutesTypes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="RoutesTypes", inversedBy="events")
     */
    protected $routeType;

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
     * @return EventsRoutesTypes
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
     * @return EventsRoutesTypes
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
     * @return EventsRoutesTypes
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
     * @return EventsRoutesTypes
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
     * Set routeType
     *
     * @param \CorahnRin\MapsBundle\Entity\RoutesTypes $routeType
     * @return EventsRoutesTypes
     */
    public function setRouteType(\CorahnRin\MapsBundle\Entity\RoutesTypes $routeType)
    {
        $this->routeType = $routeType;

        return $this;
    }

    /**
     * Get routeType
     *
     * @return \CorahnRin\MapsBundle\Entity\RoutesTypes
     */
    public function getRouteType()
    {
        return $this->routeType;
    }
}
