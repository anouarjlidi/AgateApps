<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * Maps
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="CorahnRin\MapsBundle\Repository\MapsRepository")
 */
class Maps
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
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $minZoom;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $maxZoom;

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
	 * @ORM\OneToMany(targetEntity="Routes", mappedBy="map")
	 */
	private $routes;

	/**
     * @var DoctrineCollection
	 *
	 * @ORM\OneToMany(targetEntity="Markers", mappedBy="map")
	 */
	private $markers;

	/**
     * @var DoctrineCollection
	 *
	 * @ORM\OneToMany(targetEntity="Zones", mappedBy="map")
	 */
	private $zones;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->routes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->markers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->zones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Maps
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
     * Set image
     *
     * @param string $image
     * @return Maps
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Maps
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set minZoom
     *
     * @param boolean $minZoom
     * @return Maps
     */
    public function setMinZoom($minZoom)
    {
        $this->minZoom = $minZoom;
    
        return $this;
    }

    /**
     * Get minZoom
     *
     * @return boolean 
     */
    public function getMinZoom()
    {
        return $this->minZoom;
    }

    /**
     * Set maxZoom
     *
     * @param boolean $maxZoom
     * @return Maps
     */
    public function setMaxZoom($maxZoom)
    {
        $this->maxZoom = $maxZoom;
    
        return $this;
    }

    /**
     * Get maxZoom
     *
     * @return boolean 
     */
    public function getMaxZoom()
    {
        return $this->maxZoom;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Maps
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
     * @return Maps
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
     * @param \CorahnRin\MapsBundle\Entity\Routes $routes
     * @return Maps
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
     * @return Maps
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

    /**
     * Add zones
     *
     * @param \CorahnRin\MapsBundle\Entity\Zones $zones
     * @return Maps
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
}