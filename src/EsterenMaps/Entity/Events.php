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
 * Events.
 *
 * @ORM\Table(name="events")
 * @ORM\Entity
 */
class Events
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var float
     * @ORM\Column(name="percentage", type="decimal", scale=6, precision=8, nullable=false)
     */
    protected $percentage;

    /**
     * @var Foes[]
     * @ORM\ManyToMany(targetEntity="Foes")
     */
    protected $foes;

    /**
     * @var Npcs[]
     * @ORM\ManyToMany(targetEntity="Npcs")
     */
    protected $npcs;

    /**
     * @var Weather[]
     * @ORM\ManyToMany(targetEntity="Weather")
     */
    protected $weather;

    /**
     * @var Markers[]
     * @ORM\ManyToMany(targetEntity="Markers")
     */
    protected $markers;

    /**
     * @var MarkersTypes[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="MarkersTypes")
     */
    protected $markersTypes;

    /**
     * @var Resources[]
     * @ORM\ManyToMany(targetEntity="Resources")
     */
    protected $resources;

    /**
     * @var Routes[]
     * @ORM\ManyToMany(targetEntity="Routes")
     */
    protected $routes;

    /**
     * @var RoutesTypes[]
     * @ORM\ManyToMany(targetEntity="RoutesTypes")
     */
    protected $routesTypes;

    /**
     * @var ZonesTypes[]
     * @ORM\ManyToMany(targetEntity="ZonesTypes")
     */
    protected $zonesTypes;

    /**
     * @var Zones[]
     * @ORM\ManyToMany(targetEntity="Zones")
     */
    protected $zones;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->foes = new ArrayCollection();
        $this->npcs = new ArrayCollection();
        $this->weather = new ArrayCollection();
        $this->markers = new ArrayCollection();
        $this->markersTypes = new ArrayCollection();
        $this->resources = new ArrayCollection();
        $this->routes = new ArrayCollection();
        $this->routesTypes = new ArrayCollection();
        $this->zonesTypes = new ArrayCollection();
        $this->zones = new ArrayCollection();
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
     * @return Events
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
     * Set percentage.
     *
     * @param string $percentage
     *
     * @return Events
     *
     * @codeCoverageIgnore
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Add foes.
     *
     *
     * @return Events
     */
    public function addFoe(Foes $foes)
    {
        $this->foes[] = $foes;

        return $this;
    }

    /**
     * Remove foes.
     */
    public function removeFoe(Foes $foes)
    {
        $this->foes->removeElement($foes);
    }

    /**
     * Get foes.
     *
     * @return Foes[]
     *
     * @codeCoverageIgnore
     */
    public function getFoes()
    {
        return $this->foes;
    }

    /**
     * Add npcs.
     *
     *
     * @return Events
     */
    public function addNpc(Npcs $npcs)
    {
        $this->npcs[] = $npcs;

        return $this;
    }

    /**
     * Remove npcs.
     */
    public function removeNpc(Npcs $npcs)
    {
        $this->npcs->removeElement($npcs);
    }

    /**
     * Get npcs.
     *
     * @return Npcs[]
     *
     * @codeCoverageIgnore
     */
    public function getNpcs()
    {
        return $this->npcs;
    }

    /**
     * Add weather.
     *
     *
     * @return Events
     */
    public function addWeather(Weather $weather)
    {
        $this->weather[] = $weather;

        return $this;
    }

    /**
     * Remove weather.
     */
    public function removeWeather(Weather $weather)
    {
        $this->weather->removeElement($weather);
    }

    /**
     * Get weather.
     *
     * @return Weather[]
     *
     * @codeCoverageIgnore
     */
    public function getWeather()
    {
        return $this->weather;
    }

    /**
     * Add markers.
     *
     *
     * @return Events
     */
    public function addMarker(Markers $markers)
    {
        $this->markers[] = $markers;

        return $this;
    }

    /**
     * Remove markers.
     */
    public function removeMarker(Markers $markers)
    {
        $this->markers->removeElement($markers);
    }

    /**
     * Get markers.
     *
     * @return Markers[]
     *
     * @codeCoverageIgnore
     */
    public function getMarkers()
    {
        return $this->markers;
    }

    /**
     * Add markersTypes.
     *
     *
     * @return Events
     */
    public function addMarkersType(MarkersTypes $markersTypes)
    {
        $this->markersTypes[] = $markersTypes;

        return $this;
    }

    /**
     * Remove markersTypes.
     */
    public function removeMarkersType(MarkersTypes $markersTypes)
    {
        $this->markersTypes->removeElement($markersTypes);
    }

    /**
     * Get markersTypes.
     *
     * @return MarkersTypes[]
     *
     * @codeCoverageIgnore
     */
    public function getMarkersTypes()
    {
        return $this->markersTypes;
    }

    /**
     * Add resources.
     *
     *
     * @return Events
     */
    public function addResource(Resources $resources)
    {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources.
     */
    public function removeResource(Resources $resources)
    {
        $this->resources->removeElement($resources);
    }

    /**
     * Get resources.
     *
     * @return Resources[]
     *
     * @codeCoverageIgnore
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Add routes.
     *
     *
     * @return Events
     */
    public function addRoute(Routes $routes)
    {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes.
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
     *
     * @return Events
     */
    public function addRoutesType(RoutesTypes $routesTypes)
    {
        $this->routesTypes[] = $routesTypes;

        return $this;
    }

    /**
     * Remove routesTypes.
     */
    public function removeRoutesType(RoutesTypes $routesTypes)
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
     *
     * @return Events
     */
    public function addZonesType(ZonesTypes $zonesTypes)
    {
        $this->zonesTypes[] = $zonesTypes;

        return $this;
    }

    /**
     * Remove zonesTypes.
     */
    public function removeZonesType(ZonesTypes $zonesTypes)
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

    /**
     * Add zones.
     *
     *
     * @return Events
     */
    public function addZone(Zones $zones)
    {
        $this->zones[] = $zones;

        return $this;
    }

    /**
     * Remove zones.
     */
    public function removeZone(Zones $zones)
    {
        $this->zones->removeElement($zones);
    }

    /**
     * Get zones.
     *
     * @return Zones[]
     *
     * @codeCoverageIgnore
     */
    public function getZones()
    {
        return $this->zones;
    }
}
