<?php

namespace EsterenMaps\MapsBundle\Entity;

use CorahnRin\CorahnRinBundle\Entity\Books;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;

/**
 * Factions
 *
 * @ORM\Table(name="maps_factions")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity()
 * @ExclusionPolicy("all")
 */
class Factions
{

    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     * @Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Expose
     */
    protected $description;

    /**
     * @var Zones[]
     * @ORM\OneToMany(targetEntity="Zones", mappedBy="faction")
     */
    protected $zones;

    /**
     * @var Routes[]
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="faction")
     */
    protected $routes;

    /**
     * @var Markers[]
     * @ORM\OneToMany(targetEntity="Markers", mappedBy="faction")
     */
    protected $markers;

    /**
     * @var Books[]
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Books")
     * @ORM\JoinColumn(name="book_id", nullable=false)
     */
    protected $book;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->zones   = new ArrayCollection();
        $this->routes  = new ArrayCollection();
        $this->markers = new ArrayCollection();
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
     * @param integer $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
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
     * Add zones
     *
     * @param Zones $zones
     *
     * @return Factions
     */
    public function addZone(Zones $zones)
    {
        $this->zones[] = $zones;

        return $this;
    }

    /**
     * Remove zones
     *
     * @param Zones $zones
     */
    public function removeZone(Zones $zones)
    {
        $this->zones->removeElement($zones);
    }

    /**
     * Get zones
     *
     * @return Zones[]
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * Add routes
     *
     * @param Routes $routes
     *
     * @return Factions
     */
    public function addRoute(Routes $routes)
    {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes
     *
     * @param Routes $routes
     */
    public function removeRoute(Routes $routes)
    {
        $this->routes->removeElement($routes);
    }

    /**
     * Get routes
     *
     * @return Routes[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Add markers
     *
     * @param Markers $markers
     *
     * @return Factions
     */
    public function addMarker(Markers $markers)
    {
        $this->markers[] = $markers;

        return $this;
    }

    /**
     * Remove markers
     *
     * @param Markers $markers
     */
    public function removeMarker(Markers $markers)
    {
        $this->markers->removeElement($markers);
    }

    /**
     * Get markers
     *
     * @return Markers[]
     */
    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Factions
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
     * Set book
     *
     * @param Books $book
     *
     * @return Factions
     */
    public function setBook(Books $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return Books
     */
    public function getBook()
    {
        return $this->book;
    }

}
