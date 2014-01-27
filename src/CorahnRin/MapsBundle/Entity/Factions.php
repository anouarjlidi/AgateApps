<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * Factions
 *
 * @ORM\Table(name="factions")
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\FactionsRepository")
 */
class Factions
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
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
     * @ORM\OneToMany(targetEntity="Zones", mappedBy="faction")
     */
	protected $zones;

	/**
	 * @var DoctrineCollection
	 *
	 * @ORM\OneToMany(targetEntity="Routes", mappedBy="faction")
	 */
	protected $routes;

	/**
	 * @var DoctrineCollection
	 *
	 * @ORM\OneToMany(targetEntity="Markers", mappedBy="faction")
	 */
	protected $markers;

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
        $this->zones = new \Doctrine\Common\Collections\ArrayCollection();
        $this->routes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->markers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Factions
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
     * @return Factions
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
     * @return Factions
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
     * Add zones
     *
     * @param \CorahnRin\MapsBundle\Entity\Zones $zones
     * @return Factions
     */
    public function addZone(\CorahnRin\MapsBundle\Entity\Zones $zones)
    {
        $this->zones[] = $zones;

        return $this;
    }

    /**
     * Remove zones
     *
     * @param \CorahnRin\MapsBundle\Entity\Zones $zones
     */
    public function removeZone(\CorahnRin\MapsBundle\Entity\Zones $zones)
    {
        $this->zones->removeElement($zones);
    }

    /**
     * Get zones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * Add routes
     *
     * @param \CorahnRin\MapsBundle\Entity\Routes $routes
     * @return Factions
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
     * Add markers
     *
     * @param \CorahnRin\MapsBundle\Entity\Markers $markers
     * @return Factions
     */
    public function addMarker(\CorahnRin\MapsBundle\Entity\Markers $markers)
    {
        $this->markers[] = $markers;

        return $this;
    }

    /**
     * Remove markers
     *
     * @param \CorahnRin\MapsBundle\Entity\Markers $markers
     */
    public function removeMarker(\CorahnRin\MapsBundle\Entity\Markers $markers)
    {
        $this->markers->removeElement($markers);
    }

    /**
     * Get markers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMarkers()
    {
        return $this->markers;
    }
}
