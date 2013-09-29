<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * EventsMarkersTypes
 *
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\EventsMarkersTypesRepository")
 */
class EventsMarkersTypes {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="markersTypes")
     */
    private $event;

    /**
     * @var \MarkersTypes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="MarkersTypes", inversedBy="events")
     */
    private $markerType;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;

	/**
	 * @var smallint
	 *
	 * @ORM\Column(type="smallint", nullable=false)
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
     * Set created
     *
     * @param \DateTime $created
     * @return EventsMarkersTypes
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
     * @return EventsMarkersTypes
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

    /**
     * Set markerType
     *
     * @param \CorahnRin\MapsBundle\Entity\MarkersTypes $markerType
     * @return EventsMarkersTypes
     */
    public function setMarkerType(\CorahnRin\MapsBundle\Entity\MarkersTypes $markerType)
    {
        $this->markerType = $markerType;
    
        return $this;
    }

    /**
     * Get markerType
     *
     * @return \CorahnRin\MapsBundle\Entity\MarkersTypes 
     */
    public function getMarkerType()
    {
        return $this->markerType;
    }
}