<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Resources.
 *
 * @ORM\Table(schema="maps", name="maps_resources")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity()
 */
class Resources
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var Routes[]
     * @ORM\ManyToMany(targetEntity="Routes", inversedBy="resources")
     */
    protected $routes;

    /**
     * @var RoutesTypes[]
     * @ORM\ManyToMany(targetEntity="RoutesTypes", inversedBy="resources")
     */
    protected $routesTypes;

    /**
     * @var ZonesTypes[]
     * @ORM\ManyToMany(targetEntity="ZonesTypes", inversedBy="resources")
     */
    protected $zonesTypes;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->routes      = new ArrayCollection();
        $this->routesTypes = new ArrayCollection();
        $this->zonesTypes  = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Resources
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add routes.
     *
     * @param Routes $routes
     *
     * @return Resources
     */
    public function addRoute(Routes $routes)
    {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes.
     *
     * @param Routes $routes
     */
    public function removeRoute(Routes $routes)
    {
        $this->routes->removeElement($routes);
    }

    /**
     * Get routes.
     *
     * @return Routes[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Add routesTypes.
     *
     * @param RoutesTypes $routesTypes
     *
     * @return Resources
     */
    public function addRouteType(RoutesTypes $routesTypes)
    {
        $this->routesTypes[] = $routesTypes;

        return $this;
    }

    /**
     * Remove routesTypes.
     *
     * @param RoutesTypes $routesTypes
     */
    public function removeRouteType(RoutesTypes $routesTypes)
    {
        $this->routesTypes->removeElement($routesTypes);
    }

    /**
     * Get routesTypes.
     *
     * @return RoutesTypes[]
     */
    public function getRoutesTypes()
    {
        return $this->routesTypes;
    }

    /**
     * Add zonesTypes.
     *
     * @param ZonesTypes $zonesTypes
     *
     * @return Resources
     */
    public function addZoneType(ZonesTypes $zonesTypes)
    {
        $this->zonesTypes[] = $zonesTypes;

        return $this;
    }

    /**
     * Remove zonesTypes.
     *
     * @param ZonesTypes $zonesTypes
     */
    public function removeZoneType(ZonesTypes $zonesTypes)
    {
        $this->zonesTypes->removeElement($zonesTypes);
    }

    /**
     * Get zonesTypes.
     *
     * @return ZonesTypes[]
     */
    public function getZonesTypes()
    {
        return $this->zonesTypes;
    }
}
