<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Maps
 *
 * @ORM\Table(name="maps")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity()
 * @ExclusionPolicy("all")
 * @Gedmo\Uploadable(allowOverwrite=true, filenameGenerator="SHA1")
 */
class Maps
{

    use TimestampableEntity;
    use SoftDeleteableEntity;

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
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     * @Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Expose
     */
    protected $nameSlug;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     * @Gedmo\UploadableFilePath()
     */
    protected $image;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Expose
     */
    protected $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="max_zoom", type="smallint", options={"default":1})
     * @Assert\Range(
     *      min = 1,
     *      max = 50
     * )
     * @Expose
     */
    protected $maxZoom = 10;

    /**
     * @var integer
     *
     * @ORM\Column(name="start_zoom", type="smallint", options={"default":1})
     * @Assert\Range(
     *      min = 1,
     *      max = 10
     * )
     * @Expose
     */
    protected $startZoom = 10;


    /**
     * @var integer
     *
     * @ORM\Column(name="start_x", type="smallint", options={"default":1})
     * @Expose
     */
    protected $startX = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="start_y", type="smallint", options={"default":1})
     * @Expose
     */
    protected $startY = 0;

    /**
     * @var string
     * @ORM\Column(name="bounds", type="string", options={"default": "[]"})
     */
    protected $bounds = '[]';

    /**
     * @var Routes[]
     *
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="map")
     * @Expose
     */
    protected $routes;

    /**
     * @var Markers[]
     *
     * @ORM\OneToMany(targetEntity="Markers", mappedBy="map")
     * @Expose
     */
    protected $markers;

    /**
     * @var Zones[]
     *
     * @ORM\OneToMany(targetEntity="Zones", mappedBy="map")
     * @Expose
     */
    protected $zones;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->routes  = new ArrayCollection();
        $this->markers = new ArrayCollection();
        $this->zones   = new ArrayCollection();
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
     * @param $id
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
     *
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
     *
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
     * Set maxZoom
     *
     * @param boolean $maxZoom
     *
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
     * @return integer
     */
    public function getMaxZoom()
    {
        return $this->maxZoom;
    }

    /**
     * Add routes
     *
     * @param Routes $routes
     *
     * @return Maps
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
     * Get zone
     *
     * @param Routes $route
     *
     * @return Routes
     */
    public function getRoute(Routes $route)
    {
        foreach ($this->routes as $mapRoute) {
            if ($mapRoute->getId() === $route->getId() ||
                $mapRoute->getName() === $route->getName()
            ) {
                return $mapRoute;
            }
        }

        return null;
    }

    /**
     * Get zone
     *
     * @param Routes $route
     *
     * @return Maps
     */
    public function setRoute(Routes $route)
    {
        $exists = $this->getRoute($route);
        if (!$exists) {
            $this->addRoute($route);
        } else {
            $this->routes->removeElement($exists);
            $this->addRoute($route);
        }

        return $this;
    }

    /**
     * Add markers
     *
     * @param Markers $markers
     *
     * @return Maps
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
     * Get zone
     *
     * @param Markers $marker
     *
     * @return Zones
     */
    public function getMarker(Markers $marker)
    {
        foreach ($this->markers as $mapMarker) {
            if ($mapMarker->getId() === $marker->getId() ||
                $mapMarker->getName() === $marker->getName()
            ) {
                return $mapMarker;
            }
        }

        return null;
    }

    /**
     * Contrairement au nom de cette méthode, celle-ci AJOUTE un marqueur,
     *    et uniquement si celui-ci n'est pas déjà ajouté à la map.
     *
     * @param Markers $marker
     *
     * @return $this
     */
    public function setMarker(Markers $marker)
    {
        $exists = $this->getMarker($marker);
        if (!$exists) {
            $this->addMarker($marker);
        } else {
            $this->markers->removeElement($exists);
            $this->addMarker($marker);
        }

        return $this;
    }

    /**
     * Add zones
     *
     * @param Zones $zones
     *
     * @return Maps
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
     * Get zone
     *
     * @param Zones $zone
     *
     * @return Zones
     */
    public function getZone(Zones $zone)
    {
        foreach ($this->zones as $mapZone) {
            if ($mapZone->getId() === $zone->getId() ||
                $mapZone->getName() === $zone->getName()
            ) {
                return $mapZone;
            }
        }

        return null;
    }

    /**
     * @param Zones $zone
     */
    public function setZone(Zones $zone)
    {
        $exists = $this->getZone($zone);
        if (!$exists) {
            $this->addZone($zone);
        } else {
            $this->zones->removeElement($exists);
            $this->addZone($zone);
        }
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
     * Set nameSlug
     *
     * @param string $nameSlug
     *
     * @return Maps
     */
    public function setNameSlug($nameSlug)
    {
        $this->nameSlug = $nameSlug;

        return $this;
    }

    /**
     * Get nameSlug
     *
     * @return string
     */
    public function getNameSlug()
    {
        return $this->nameSlug;
    }

    /**
     * @return int
     */
    public function getStartZoom()
    {
        return $this->startZoom;
    }

    /**
     * @param int $startZoom
     *
     * @return $this
     */
    public function setStartZoom($startZoom)
    {
        $this->startZoom = $startZoom;

        return $this;
    }

    /**
     * @return int
     */
    public function getStartX()
    {
        return $this->startX;
    }

    /**
     * @param int $startX
     *
     * @return $this
     */
    public function setStartX($startX)
    {
        $this->startX = $startX;

        return $this;
    }

    /**
     * @return int
     */
    public function getStartY()
    {
        return $this->startY;
    }

    /**
     * @param int $startY
     *
     * @return $this
     */
    public function setStartY($startY)
    {
        $this->startY = $startY;

        return $this;
    }

    /**
     * @return string
     */
    public function getBounds()
    {
        return $this->bounds;
    }

    /**
     * @param string $bounds
     *
     * @return Maps
     */
    public function setBounds($bounds)
    {
        $this->bounds = $bounds;

        return $this;
    }

    /**
     * Réinitialise correctement les informations de la map
     */
    public function refresh()
    {
        foreach ($this->routes as $route) {
            $route->refresh();
        }

        return $this;
    }

    /**
     * @return array
     * @VirtualProperty()
     */
    public function getJsonBounds()
    {
        return json_decode($this->bounds, true);
    }

    /**
     * @param array $bounds
     * @return $this
     */
    public function setJsonBounds(array $bounds = array())
    {
        $this->bounds = json_encode($bounds);
        return $this;
    }

}
