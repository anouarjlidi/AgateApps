<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Resources.
 *
 * @ORM\Table(name="maps_resources")
 * @ORM\Entity()
 */
class Resources
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id()
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
     * @ORM\ManyToMany(targetEntity="Routes")
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

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id.
     *
     * @return int
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getZonesTypes()
    {
        return $this->zonesTypes;
    }
}
