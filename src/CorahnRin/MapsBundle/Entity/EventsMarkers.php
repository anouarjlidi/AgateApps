<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventsMarkers
 *
 * @ORM\Table(name="event_markers")
 * @ORM\Entity
 */
class EventsMarkers {
    /**
     * @var \Events
     *
     * @ORM\Column(name="id_events", type="integer", length=255, nullable=false)
     */
    private $event;
	
    /**
     * @var \Markers
     *
     * @ORM\Column(name="id_markers", type="integer", nullable=false)
     * @ORM\Id
     */
    private $marker;

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
     * @return EventsMarkers
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
     * Set marker
     *
     * @param integer $marker
     * @return EventsMarkers
     */
    public function setMarker($marker)
    {
        $this->marker = $marker;
    
        return $this;
    }

    /**
     * Get marker
     *
     * @return integer 
     */
    public function getMarker()
    {
        return $this->marker;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return EventsMarkers
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
     * @return EventsMarkers
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
     * @return EventsMarkers
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