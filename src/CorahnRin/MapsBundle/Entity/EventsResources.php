<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * EventsResources
 *
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\EventsResourcesRepository")
 */
class EventsResources {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="resources")
     */
    protected $event;

    /**
     * @var \Resources
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Resources", inversedBy="events")
     */
    protected $resource;

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
     * Set created
     *
     * @param \DateTime $created
     * @return EventsResources
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
     * @return EventsResources
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

    /**
     * Set event
     *
     * @param \CorahnRin\MapsBundle\Entity\Events $event
     * @return EventsResources
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
     * Set resource
     *
     * @param \CorahnRin\MapsBundle\Entity\Resources $resource
     * @return EventsResources
     */
    public function setResource(\CorahnRin\MapsBundle\Entity\Resources $resource)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return \CorahnRin\MapsBundle\Entity\Resources 
     */
    public function getResource()
    {
        return $this->resource;
    }
}
