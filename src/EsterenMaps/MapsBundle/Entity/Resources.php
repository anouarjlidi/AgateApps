<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * Resources
 *
 * @ORM\Table(name="resources")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\ResourcesRepository")
 */
class Resources
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    protected $name;

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
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Routes", inversedBy="resources")
     */
    protected $routes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="RoutesTypes", inversedBy="resources")
     */
    protected $routesTypes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="EventsResources", mappedBy="resource")
     */
	protected $events;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
     */
    protected $deleted;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->routes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routesTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Resources
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Resources
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
     * @return Resources
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
     * Add routes
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routes
     * @return Resources
     */
    public function addRoute(\EsterenMaps\MapsBundle\Entity\Routes $routes)
    {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routes
     */
    public function removeRoute(\EsterenMaps\MapsBundle\Entity\Routes $routes)
    {
        $this->routes->removeElement($routes);
    }

    /**
     * Get routes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Add routesTypes
     *
     * @param \EsterenMaps\MapsBundle\Entity\RoutesTypes $routesTypes
     * @return Resources
     */
    public function addRoutesType(\EsterenMaps\MapsBundle\Entity\RoutesTypes $routesTypes)
    {
        $this->routesTypes[] = $routesTypes;

        return $this;
    }

    /**
     * Remove routesTypes
     *
     * @param \EsterenMaps\MapsBundle\Entity\RoutesTypes $routesTypes
     */
    public function removeRoutesType(\EsterenMaps\MapsBundle\Entity\RoutesTypes $routesTypes)
    {
        $this->routesTypes->removeElement($routesTypes);
    }

    /**
     * Get routesTypes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoutesTypes()
    {
        return $this->routesTypes;
    }

    /**
     * Add events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsResources $events
     * @return Resources
     */
    public function addEvent(\EsterenMaps\MapsBundle\Entity\EventsResources $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsResources $events
     */
    public function removeEvent(\EsterenMaps\MapsBundle\Entity\EventsResources $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Resources
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
