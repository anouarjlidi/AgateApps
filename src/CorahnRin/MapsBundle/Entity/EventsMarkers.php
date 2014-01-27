<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * EventsMarkers
 *
 * @ORM\Table(name="events_markers")
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\EventsMarkersRepository")
 */
class EventsMarkers {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="markers")
     */
    protected $event;

    /**
     * @var \Markers
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="events")
     */
    protected $marker;

	/**
	 * @var smallint
	 *
	 * @ORM\Column(type="smallint")
	 */
	protected $percentage;

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
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
     */
    protected $deleted;

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
     * Set event
     *
     * @param \CorahnRin\MapsBundle\Entity\Events $event
     * @return EventsMarkers
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

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return EventsMarkers
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
