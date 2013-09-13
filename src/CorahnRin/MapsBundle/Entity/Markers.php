<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Markers
 *
 * @ORM\Table(name="markers")
 * @ORM\Entity
 */
class Markers
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="coordinates", type="text", nullable=false)
     */
    private $coordinates;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    private $dateModified;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Routes", mappedBy="markers")
     */
    private $routes;

    /**
     * @var \Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_factions", referencedColumnName="id")
     * })
     */
    private $factions;

    /**
     * @var \Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_maps", referencedColumnName="id")
     * })
     */
    private $maps;

    /**
     * @var \MarkersType
     *
     * @ORM\ManyToOne(targetEntity="MarkersType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_markers_type", referencedColumnName="id")
     * })
     */
    private $markerType;
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->routes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Markers
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
     * Set coordinates
     *
     * @param string $coordinates
     * @return Markers
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;
    
        return $this;
    }

    /**
     * Get coordinates
     *
     * @return string 
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Markers
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateModified
     *
     * @param \DateTime $dateModified
     * @return Markers
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;
    
        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime 
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * Add routes
     *
     * @param \CorahnRin\MapsBundle\Entity\Routes $routes
     * @return Markers
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
     * Set factions
     *
     * @param \CorahnRin\MapsBundle\Entity\Factions $factions
     * @return Markers
     */
    public function setFactions(\CorahnRin\MapsBundle\Entity\Factions $factions = null)
    {
        $this->factions = $factions;
    
        return $this;
    }

    /**
     * Get factions
     *
     * @return \CorahnRin\MapsBundle\Entity\Factions 
     */
    public function getFactions()
    {
        return $this->factions;
    }

    /**
     * Set maps
     *
     * @param \CorahnRin\MapsBundle\Entity\Maps $maps
     * @return Markers
     */
    public function setMaps(\CorahnRin\MapsBundle\Entity\Maps $maps = null)
    {
        $this->maps = $maps;
    
        return $this;
    }

    /**
     * Get maps
     *
     * @return \CorahnRin\MapsBundle\Entity\Maps 
     */
    public function getMaps()
    {
        return $this->maps;
    }

    /**
     * Set markerType
     *
     * @param \CorahnRin\MapsBundle\Entity\MarkersType $markerType
     * @return Markers
     */
    public function setMarkerType(\CorahnRin\MapsBundle\Entity\MarkersType $markerType = null)
    {
        $this->markerType = $markerType;
    
        return $this;
    }

    /**
     * Get markerType
     *
     * @return \CorahnRin\MapsBundle\Entity\MarkersType 
     */
    public function getMarkerType()
    {
        return $this->markerType;
    }
}