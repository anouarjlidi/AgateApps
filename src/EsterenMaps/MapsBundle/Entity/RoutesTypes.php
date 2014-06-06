<?php

namespace EsterenMaps\MapsBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;

/**
 * RoutesTypes
 *
 * @ORM\Table(name="routes_types")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\RoutesTypesRepository")
 * @ExclusionPolicy("all")
 */
class RoutesTypes
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Expose
     */
    protected $name;

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
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="routesTypes")
     */
    protected $resources;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="routeType")
     */
	protected $routes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="EventsRoutesTypes", mappedBy="routeType")
     */
	protected $events;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param \EsterenMaps\MapsBundle\Entity\Resources $resources
     * @return RoutesTypes
     */
    public function addResource(\EsterenMaps\MapsBundle\Entity\Resources $resources)
    {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources
     *
     * @param \EsterenMaps\MapsBundle\Entity\Resources $resources
     */
    public function removeResource(\EsterenMaps\MapsBundle\Entity\Resources $resources)
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
     * Add routes
     *
     * @param \EsterenMaps\MapsBundle\Entity\Routes $routes
     * @return RoutesTypes
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
     * Add events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsRoutesTypes $events
     * @return RoutesTypes
     */
    public function addEvent(\EsterenMaps\MapsBundle\Entity\EventsRoutesTypes $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsRoutesTypes $events
     */
    public function removeEvent(\EsterenMaps\MapsBundle\Entity\EventsRoutesTypes $events)
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
