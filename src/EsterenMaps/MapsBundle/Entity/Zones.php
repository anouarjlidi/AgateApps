<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EsterenMaps\MapsBundle\Cache\ClearerEntityInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * Zones.
 *
 * @ORM\Table(name="maps_zones")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity()
 * @Serializer\ExclusionPolicy("all")
 */
class Zones implements ClearerEntityInterface
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
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
    protected $coordinates = '';

    /**
     * @var Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="zones")
     * @ORM\JoinColumn(name="map_id", nullable=false)
     */
    protected $map;

    /**
     * @var Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="zones")
     * @ORM\JoinColumn(name="faction_id", nullable=true)
     * @Serializer\Expose
     */
    protected $faction;

    /**
     * @var ZonesTypes
     *
     * @ORM\ManyToOne(targetEntity="ZonesTypes", inversedBy="zones")
     * @ORM\JoinColumn(name="zone_type_id", nullable=false)
     * @Serializer\Expose
     */
    protected $zoneType;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
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
     * Set id.
     *
     * @param int $id
     *
     * @return Zones
     *
     * @codeCoverageIgnore
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
     * @return Zones
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
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Zones
     *
     * @codeCoverageIgnore
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
     * @return Zones
     *
     * @codeCoverageIgnore
     */
    public function setCoordinates($coordinates)
    {
        $this->coordinates = $coordinates;

        return $this;
    }

    /**
     * Get coordinates.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Set map.
     *
     * @param Maps $map
     *
     * @return Zones
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     * @return Zones
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set zoneType.
     *
     * @param ZonesTypes $zoneType
     *
     * @return Zones
     *
     * @codeCoverageIgnore
     */
    public function setZoneType(ZonesTypes $zoneType = null)
    {
        $this->zoneType = $zoneType;

        return $this;
    }

    /**
     * Get zoneType.
     *
     * @return ZonesTypes
     *
     * @codeCoverageIgnore
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
        return $this->coordinates !== null && count($this->getDecodedCoordinates());
    }

    /**
     * @return array
     */
    public function getDecodedCoordinates()
    {
        return json_decode($this->coordinates, true) ?: [];
    }
}
