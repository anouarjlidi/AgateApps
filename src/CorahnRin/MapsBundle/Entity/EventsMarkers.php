<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * EventsMarkers
 *
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\EventsMarkersRepository")
 */
class EventsMarkers {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="markers")
     */
    private $event;

    /**
     * @var \Markers
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="events")
     */
    private $marker;

	/**
	 * @var smallint
	 *
	 * @ORM\Column(type="smallint", nullable=false)
	 */
	private $percentage;

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

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return EventsMarkers
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
     * @return EventsMarkers
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
     * Set marker
     *
     * @param \CorahnRin\MapsBundle\Entity\Markers $marker
     * @return EventsMarkers
     */
    public function setMarker(\CorahnRin\MapsBundle\Entity\Markers $marker)
    {
        $this->marker = $marker;
    
        return $this;
    }

    /**
     * Get marker
     *
     * @return \CorahnRin\MapsBundle\Entity\Markers 
     */
    public function getMarker()
    {
        return $this->marker;
    }
}