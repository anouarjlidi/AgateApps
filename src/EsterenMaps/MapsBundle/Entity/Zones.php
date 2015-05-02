<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * Zones
 *
 * @ORM\Table(name="maps_zones")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity()
 * @Serializer\ExclusionPolicy("all")
 */
class Zones
{

    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
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
    protected $coordinates;

    /**
     * @var Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="zones", fetch="EAGER")
     * @ORM\JoinColumn(name="map_id", nullable=false)
     */
    protected $map;

    /**
     * @var Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="zones", fetch="EAGER", fetch="EAGER")
     * @ORM\JoinColumn(name="faction_id", nullable=true)
     * @Serializer\Expose
     */
    protected $faction;

    /**
     * @var ZonesTypes
     *
     * @ORM\ManyToOne(targetEntity="ZonesTypes", inversedBy="zones", fetch="EAGER", fetch="EAGER")
     * @ORM\JoinColumn(name="zone_type_id", nullable=false)
     * @Serializer\Expose
     */
    protected $zoneType;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
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
     * Set id
     *
     * @param integer $id
     *
     * @return Zones
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
     * @return Zones
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
     * Set coordinates
     *
     * @param string $coordinates
     *
     * @return Zones
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
     * Set map
     *
     * @param Maps $map
     *
     * @return Zones
     */
    public function setMap(Maps $map = null)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return Maps
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set faction
     *
     * @param Factions $faction
     *
     * @return Zones
     */
    public function setFaction(Factions $faction = null)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction
     *
     * @return Factions
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set zoneType
     *
     * @param ZonesTypes $zoneType
     *
     * @return Zones
     */
    public function setZoneType(ZonesTypes $zoneType = null)
    {
        $this->zoneType = $zoneType;

        return $this;
    }

    /**
     * Get zoneType
     *
     * @return ZonesTypes
     */
    public function getZoneType()
    {
        return $this->zoneType;
    }

    /**
     * @return bool
     */
    public function isLocalized()
    {
        return $this->coordinates !== null;
    }
}
