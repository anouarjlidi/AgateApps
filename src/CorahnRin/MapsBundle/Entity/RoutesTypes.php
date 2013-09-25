<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * RoutesTypes
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\RoutesTypesRepository")
 */
class RoutesTypes
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

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
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="routesTypes")
     */
    private $resources;
	
    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="RoutesTypes", mappedBy="routeType")
     */
	private $routesTypes;
	
    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="route")
     */
	private $routes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="events")
     */
	private $events;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routesTypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return RoutesTypes
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
     * @return RoutesTypes
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
     * @return RoutesTypes
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
     * Add resources
     *
     * @param \CorahnRin\MapsBundle\Entity\Resources $resources
     * @return RoutesTypes
     */
    public function addResource(\CorahnRin\MapsBundle\Entity\Resources $resources)
    {
        $this->resources[] = $resources;
    
        return $this;
    }

    /**
     * Remove resources
     *
     * @param \CorahnRin\MapsBundle\Entity\Resources $resources
     */
    public function removeResource(\CorahnRin\MapsBundle\Entity\Resources $resources)
    {
        $this->resources->removeElement($resources);
    }

    /**
     * Get resources
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Add routesTypes
     *
     * @param \CorahnRin\MapsBundle\Entity\RoutesTypes $routesTypes
     * @return RoutesTypes
     */
    public function addRoutesType(\CorahnRin\MapsBundle\Entity\RoutesTypes $routesTypes)
    {
        $this->routesTypes[] = $routesTypes;
    
        return $this;
    }

    /**
     * Remove routesTypes
     *
     * @param \CorahnRin\MapsBundle\Entity\RoutesTypes $routesTypes
     */
    public function removeRoutesType(\CorahnRin\MapsBundle\Entity\RoutesTypes $routesTypes)
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
     * Add routes
     *
     * @param \CorahnRin\MapsBundle\Entity\Routes $routes
     * @return RoutesTypes
     */
    public function addRoute(\CorahnRin\MapsBundle\Entity\Routes $routes)
    {
        $this->routes[] = $routes;
    
        return $this;
    }

    /**
     * Remove routes
     *
     * @param \CorahnRin\MapsBundle\Entity\Routes $routes
     */
    public function removeRoute(\CorahnRin\MapsBundle\Entity\Routes $routes)
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
     * Add events
     *
     * @param \CorahnRin\MapsBundle\Entity\Events $events
     * @return RoutesTypes
     */
    public function addEvent(\CorahnRin\MapsBundle\Entity\Events $events)
    {
        $this->events[] = $events;
    
        return $this;
    }

    /**
     * Remove events
     *
     * @param \CorahnRin\MapsBundle\Entity\Events $events
     */
    public function removeEvent(\CorahnRin\MapsBundle\Entity\Events $events)
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
}