<?php

namespace EsterenMaps\MapsBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * EventsMarkers
 *
 * @ORM\Table(name="events_markers")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\EventsMarkersRepository")
 */
class EventsMarkers {

    /**
     * @var Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="markers")
     */
    protected $event;

    /**
     * @var Markers
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
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

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
     * @param \EsterenMaps\MapsBundle\Entity\Events $event
     * @return EventsMarkers
     */
    public function setEvent(\EsterenMaps\MapsBundle\Entity\Events $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \EsterenMaps\MapsBundle\Entity\Events
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set marker
     *
     * @param \EsterenMaps\MapsBundle\Entity\Markers $marker
     * @return EventsMarkers
     */
    public function setMarker(\EsterenMaps\MapsBundle\Entity\Markers $marker)
    {
        $this->marker = $marker;

        return $this;
    }

    /**
     * Get marker
     *
     * @return \EsterenMaps\MapsBundle\Entity\Markers
     */
    public function getMarker()
    {
        return $this->marker;
    }
}
