<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * Routes.
 *
 * @ORM\Table(schema="maps", name="maps_routes")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\RoutesRepository")
 * @ORM\HasLifecycleCallbacks
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @Serializer\ExclusionPolicy("all")
 */
class Routes
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     * @Serializer\Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="coordinates", type="text")
     * @Serializer\Expose
     */
    protected $coordinates = '';

    /**
     * @var int
     *
     * @ORM\Column(name="distance", type="float", precision=12, scale=6, options={"default":0})
     * @Serializer\Expose
     */
    protected $distance = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="forced_distance", type="float", precision=12, scale=6, nullable=true)
     * @Serializer\Expose
     */
    protected $forcedDistance;

    /**
     * @var bool
     *
     * @ORM\Column(name="guarded", type="boolean")
     * @Serializer\Expose
     */
    protected $guarded = false;

    /**
     * @var Resources
     *
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="routes")
     */
    protected $resources;

    /**
     * @var Markers
     *
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="routesStart")
     * @ORM\JoinColumn(name="marker_start_id", nullable=true)
     * @Serializer\Expose
     */
    protected $markerStart;

    /**
     * @var Markers
     *
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="routesEnd")
     * @ORM\JoinColumn(name="marker_end_id", nullable=true)
     * @Serializer\Expose
     */
    protected $markerEnd;

    /**
     * @var Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="routes")
     * @ORM\JoinColumn(name="map_id", nullable=false)
     */
    protected $map;

    /**
     * @var Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="routes", fetch="EAGER")
     * @ORM\JoinColumn(name="faction_id", nullable=true)
     * @Serializer\Expose
     */
    protected $faction;

    /**
     * @var RoutesTypes
     *
     * @ORM\ManyToOne(targetEntity="RoutesTypes", inversedBy="routes", fetch="EAGER")
     * @ORM\JoinColumn(name="route_type_id", nullable=false)
     * @Serializer\Expose
     */
    protected $routeType;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->resources = new ArrayCollection();
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
     * Set id.
     *
     * @param string $id
     *
     * @return Routes
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Routes
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Routes
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set coordinates.
     *
     * @param string $coordinates
     *
     * @return Routes
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;

        $this->calcDistance();

        return $this;
    }

    /**
     * Get coordinates.
     *
     * @return string
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Add resources.
     *
     * @param Resources $resources
     *
     * @return Routes
     */
    public function addResource(Resources $resources)
    {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources.
     *
     * @param Resources $resources
     */
    public function removeResource(Resources $resources)
    {
        $this->resources->removeElement($resources);
    }

    /**
     * Get resources.
     *
     * @return Resources[]
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Set map.
     *
     * @param Maps $map
     *
     * @return Routes
     */
    public function setMap(Maps $map = null)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map.
     *
     * @return Maps
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set faction.
     *
     * @param Factions $faction
     *
     * @return Routes
     */
    public function setFaction(Factions $faction = null)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction.
     *
     * @return Factions
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set routeType.
     *
     * @param RoutesTypes $routeType
     *
     * @return Routes
     */
    public function setRouteType(RoutesTypes $routeType = null)
    {
        $this->routeType = $routeType;

        return $this;
    }

    /**
     * Get routeType.
     *
     * @return RoutesTypes
     */
    public function getRouteType()
    {
        return $this->routeType;
    }

    /**
     * Set markerStart.
     *
     * @param Markers $markerStart
     *
     * @return Routes
     */
    public function setMarkerStart(Markers $markerStart = null)
    {
        $this->markerStart = $markerStart;

        return $this;
    }

    /**
     * Get markerStart.
     *
     * @return Markers
     */
    public function getMarkerStart()
    {
        return $this->markerStart;
    }

    /**
     * Set markerEnd.
     *
     * @param Markers $markerEnd
     *
     * @return Routes
     */
    public function setMarkerEnd(Markers $markerEnd = null)
    {
        $this->markerEnd = $markerEnd;

        return $this;
    }

    /**
     * Get markerEnd.
     *
     * @return Markers
     */
    public function getMarkerEnd()
    {
        return $this->markerEnd;
    }

    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param int $distance
     *
     * @return Routes
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return int
     */
    public function getForcedDistance()
    {
        return $this->forcedDistance;
    }

    /**
     * @param int $forcedDistance
     *
     * @return Routes
     */
    public function setForcedDistance($forcedDistance)
    {
        $this->forcedDistance = $forcedDistance;

        return $this;
    }

    /**
     * @return bool
     */
    public function isGuarded()
    {
        return $this->guarded;
    }

    /**
     * @param bool $guarded
     *
     * @return Routes
     */
    public function setGuarded($guarded)
    {
        $this->guarded = $guarded;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLocalized()
    {
        return $this->coordinates !== null && count($this->coordinates);
    }

    /**
     * @return array
     */
    public function getDecodedCoordinates()
    {
        return json_decode($this->coordinates, true);
    }

    /**
     * Réinitialise correctement les informations de la route.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     *
     * @return Routes
     */
    public function refresh()
    {
        if (!$this->coordinates) {
            $this->coordinates = '[]';
        }
        $coords = json_decode($this->coordinates, true);

        if ($this->markerStart && isset($coords[0])) {
            $coords[0] = [
                'lat' => $this->markerStart->getLatitude(),
                'lng' => $this->markerStart->getLongitude(),
            ];
        }
        if ($this->markerEnd) {
            $coords[count($coords) - ((int) (count($coords) > 1))] = [
                'lat' => $this->markerEnd->getLatitude(),
                'lng' => $this->markerEnd->getLongitude(),
            ];
        }

        $this->calcDistance();

        $this->setCoordinates(json_encode($coords));

        return $this;
    }

    /**
     * @return int
     */
    public function calcDistance()
    {
        // Override distance if we have set forcedDistance
        if ($this->forcedDistance) {
            $this->distance = $this->forcedDistance;

            return $this->forcedDistance;
        } else {
            // Else, we force the null value
            $this->forcedDistance = null;
        }

        $distance = 0;
        $points   = json_decode($this->coordinates, true);

        reset($points);

        // Use classic Pythagore's theorem to calculate distances.
        while ($current = current($points)) {
            $next = next($points);
            if (false !== $next) {
                $currentX = $current['lng'];
                $currentY = $current['lat'];
                $nextX    = $next['lng'];
                $nextY    = $next['lat'];

                $distance += sqrt(
                    ($nextX * $nextX)
                    - (2 * $currentX * $nextX)
                    + ($currentX * $currentX)
                    + ($nextY * $nextY)
                    - (2 * $currentY * $nextY)
                    + ($currentY * $currentY)
                );
            }
        }

        // Apply map ratio to distance.
        $distance = $this->map->getCoordinatesRatio() * $distance;

        /**
         * The "substr" trick truncates the numbers, else mysql 5.7 would throw a warning.
         * This parameter should depend on the "precision" specified in the $distance property.
         * @see Routes::$distance
         */
        $floatPrecision = 12;

        $distance = (float) substr($distance, 0, $floatPrecision);

        if ($distance !== (float) substr($this->distance, 0, $floatPrecision)) {
            $this->distance = $distance;
        }

        return $distance;
    }
}
