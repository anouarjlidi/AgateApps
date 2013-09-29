<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * EventsRoutesTypes
 *
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\EventsRoutesTypesRepository")
 */
class EventsRoutesTypes {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="routesTypes")
     */
    private $event;

    /**
     * @var \RoutesTypes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="RoutesTypes", inversedBy="events")
     */
    private $route_type;

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
     * Set route_type
     *
     * @param \CorahnRin\MapsBundle\Entity\RoutesTypes $routeType
     * @return EventsRoutesTypes
     */
    public function setRouteType(\CorahnRin\MapsBundle\Entity\RoutesTypes $routeType)
    {
        $this->route_type = $routeType;
    
        return $this;
    }

    /**
     * Get route_type
     *
     * @return \CorahnRin\MapsBundle\Entity\RoutesTypes 
     */
    public function getRouteType()
    {
        return $this->route_type;
    }
}