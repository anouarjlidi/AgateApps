<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use EsterenMaps\MapsBundle\Cache\ClearerEntityInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * ZonesTypes.
 *
 * @ORM\Table(name="maps_zones_types")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity()
 * @ExclusionPolicy("all")
 */
class ZonesTypes implements ClearerEntityInterface
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
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
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Expose
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=75, nullable=true)
     * @Expose
     */
    protected $color;

    /**
     * @var Resources[]
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="zonesTypes")
     */
    protected $resources;

    /**
     * @var ZonesTypes
     *
     * @ORM\ManyToOne(targetEntity="ZonesTypes", fetch="EXTRA_LAZY")
     * @ORM\JoinColumn(nullable=true)
     */
    protected $parent;

    /**
     * @var Zones[]
     * @ORM\OneToMany(targetEntity="Zones", mappedBy="zoneType")
     */
    protected $zones;

    protected $children = [];

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->resources = new ArrayCollection();
        $this->zones     = new ArrayCollection();
    }

    public function __toString()
    {
        return ($this->parent ? '> ' : '').$this->id.' '.$this->name;
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
     * @param int $id
     *
     * @return $this
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
     * @return ZonesTypes
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
     * Add resources.
     *
     * @param Resources $resources
     *
     * @return ZonesTypes
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
     * Add zones.
     *
     * @param Zones $zones
     *
     * @return ZonesTypes
     */
    public function addZone(Zones $zones)
    {
        $this->zones[] = $zones;

        return $this;
    }

    /**
     * Remove zones.
     *
     * @param Zones $zones
     */
    public function removeZone(Zones $zones)
    {
        $this->zones->removeElement($zones);
    }

    /**
     * Get zones.
     *
     * @return Zones[]
     */
    public function getZones()
    {
        return $this->zones;
    }

    /**
     * Set parent.
     *
     * @param ZonesTypes $parent
     *
     * @return ZonesTypes
     */
    public function setParent(ZonesTypes $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return ZonesTypes
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param ZonesTypes $child
     *
     * @return $this
     */
    public function addChild($child)
    {
        $this->children[$child->getId()] = $child;

        return $this;
    }

    /**
     * @param ZonesTypes[] $children
     *
     * @return $this
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @return ZonesTypes[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param ZonesTypes $child
     *
     * @return $this
     */
    public function removeChild($child)
    {
        if (is_numeric($child)) {
            unset($this->children[$child]);
        } elseif (is_object($child)) {
            unset($this->children[$child->getId()]);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     *
     * @return RoutesTypes
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Retourne le parent à un certain niveau d'héritage.
     *
     * @param int $level
     *
     * @return ZonesTypes|null
     */
    public function getParentByLevel($level = 0)
    {
        /** @var ZonesTypes $actualParent */
        $actualParent = $this->parent;
        if ($actualParent) {
            while ($level > 0) {
                $actualParent = $actualParent->getParent();
                --$level;
                if (!$actualParent && $level > 0) {
                    $level = 0;
                }
            }
        }

        return $actualParent;
    }
}
