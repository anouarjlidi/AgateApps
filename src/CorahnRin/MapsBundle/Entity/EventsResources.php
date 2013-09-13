<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventsResources
 *
 * @ORM\Table(name="event_resources")
 * @ORM\Entity
 */
class EventsResources
{
    /**
     * @var \Events
     *
     * @ORM\Column(name="id_events", type="integer", length=255, nullable=false)
     */
    private $event;
	
    /**
     * @var \Resources
     *
     * @ORM\Column(name="id_resources", type="integer", nullable=false)
     * @ORM\Id
     */
    private $resource;

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
     * @return EventsResources
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
     * Set resource
     *
     * @param integer $resource
     * @return EventsResources
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    
        return $this;
    }

    /**
     * Get resource
     *
     * @return integer 
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return EventsResources
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
     * @return EventsResources
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
     * @return EventsResources
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