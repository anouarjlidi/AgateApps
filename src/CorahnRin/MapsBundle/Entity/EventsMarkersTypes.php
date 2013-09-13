<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventsMarkersTypes
 *
 * @ORM\Table(name="event_markers_types")
 * @ORM\Entity
 */
class EventsMarkersTypes {
    /**
     * @var \Events
     *
     * @ORM\Column(name="id_events", type="integer", length=255, nullable=false)
     */
    private $event;
	
    /**
     * @var \MarkersTypes
     *
     * @ORM\Column(name="id_markers_types", type="integer", nullable=false)
     * @ORM\Id
     */
    private $marker_type;

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
     * @return EventsMarkersTypes
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
     * Set marker_type
     *
     * @param integer $markerType
     * @return EventsMarkersTypes
     */
    public function setMarkerType($markerType)
    {
        $this->marker_type = $markerType;
    
        return $this;
    }

    /**
     * Get marker_type
     *
     * @return integer 
     */
    public function getMarkerType()
    {
        return $this->marker_type;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return EventsMarkersTypes
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
     * @return EventsMarkersTypes
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
     * @return EventsMarkersTypes
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