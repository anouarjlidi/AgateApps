<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;

/**
 * ZonesTypes
 *
 * @ORM\Table(name="maps_zones_types")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 * @ExclusionPolicy("all")
 */
class ZonesTypes {

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
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Expose
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=75, nullable=true)
     * @Expose
     */
    protected $color;

    /**
     * @var \Datetime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

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

    /**
     * @var EventsZonesTypes[]
     * @ORM\OneToMany(targetEntity="EventsZonesTypes", mappedBy="zoneType")
     */
    protected $events;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    protected $children = array();

    /**
     * Constructor
     */
    public function __construct() {
        $this->resources = new ArrayCollection();
        $this->zones = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function __toString()
    {
        return ($this->parent ? '> ' : '').$this->id.' '.$this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ZonesTypes
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ZonesTypes
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return ZonesTypes
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Add resources
     *
     * @param Resources $resources
     * @return ZonesTypes
     */
    public function addResource(Resources $resources) {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources
     *
     * @param Resources $resources
     */
    public function removeResource(Resources $resources) {
        $this->resources->removeElement($resources);
    }

    /**
     * Get resources
     *
     * @return Resources[]
     */
    public function getResources() {
        return $this->resources;
    }

    /**
     * Add zones
     *
     * @param Zones $zones
     * @return ZonesTypes
     */
    public function addZone(Zones $zones) {
        $this->zones[] = $zones;

        return $this;
    }

    /**
     * Remove zones
     *
     * @param Zones $zones
     */
    public function removeZone(Zones $zones) {
        $this->zones->removeElement($zones);
    }

    /**
     * Get zones
     *
     * @return Zones[]
     */
    public function getZones() {
        return $this->zones;
    }

    /**
     * Add events
     *
     * @param EventsZonesTypes $events
     * @return ZonesTypes
     */
    public function addEvent(EventsZonesTypes $events) {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param EventsZonesTypes $events
     */
    public function removeEvent(EventsZonesTypes $events) {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return Events[]
     */
    public function getEvents() {
        return $this->events;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return ZonesTypes
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted() {
        return $this->deleted;
    }

    /**
     * Set parent
     *
     * @param ZonesTypes $parent
     * @return ZonesTypes
     */
    public function setParent(ZonesTypes $parent = null) {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return ZonesTypes
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * @param ZonesTypes $child
     * @return $this
     */
    public function addChild($child) {
        $this->children[$child->getId()] = $child;
        return $this;
    }

    /**
     * @param ZonesTypes[] $children
     * @return $this
     */
    public function setChildren($children) {
        $this->children = $children;
        return $this;
    }

    /**
     * @return ZonesTypes[]
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @param ZonesTypes $child
     * @return $this
     */
    public function removeChild($child) {
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
     * @return RoutesTypes
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Retourne le parent à un certain niveau d'héritage
     *
     * @param int $level
     * @return ZonesTypes|null
     */
    public function getParentByLevel($level = 0) {
        $actualParent = $this->parent;
        if ($actualParent) {
            while ($level > 0) {
                $actualParent = $actualParent->getParent();
                $level--;
                if (!$actualParent && $level > 0) {
                    $level = 0;
                }
            }
        }
        return $actualParent;
    }

}
