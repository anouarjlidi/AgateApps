<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventsRoutesTypes
 *
 * @ORM\Table(name="event_routes_types")
 * @ORM\Entity
 */
class EventsRoutesTypes {
    /**
     * @var \Events
     *
     * @ORM\Column(name="id_events", type="integer", length=255, nullable=false)
     */
    private $event;
	
    /**
     * @var \RoutesTypes
     *
     * @ORM\Column(name="id_routes_types", type="integer", nullable=false)
     * @ORM\Id
     */
    private $route_type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    private $dateModified;

	/**
	 * @var smallint
	 * 
	 * @ORM\Column(name="percentage", type="smallint", nullable=false)
	 */
	private $percentage;

    /**
     * Set event
     *
     * @param integer $event
     * @return EventsRoutesTypes
     */
    public function setEvent($event)
    {
        $this->event = $event;
    
        return $this;
    }

    /**
     * Get event
     *
     * @return integer 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set route_type
     *
     * @param integer $routeType
     * @return EventsRoutesTypes
     */
    public function setRouteType($routeType)
    {
        $this->route_type = $routeType;
    
        return $this;
    }

    /**
     * Get route_type
     *
     * @return integer 
     */
    public function getRouteType()
    {
        return $this->route_type;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return EventsRoutesTypes
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return EventsRoutesTypes
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;
    
        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->dateModified;
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
}