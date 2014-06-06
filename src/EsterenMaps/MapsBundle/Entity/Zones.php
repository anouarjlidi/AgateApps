<?php

namespace EsterenMaps\MapsBundle\Entity;

use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * Zones
 *
 * @ORM\Table(name="zones")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\ZonesRepository")
 * @ExclusionPolicy("all")
 */
class Zones
{
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
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     * @Expose
     */
    protected $coordinates;

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
     * @var Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="zones")
     */
    protected $map;

    /**
     * @var Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="zones")
     * @Expose
     */
    protected $faction;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="EventsZones", mappedBy="zone")
     */
	protected $events;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @param integer $name
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
     * Set coordinates
     *
     * @param string $coordinates
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
     * Set created
     *
     * @param \DateTime $created
     * @return Zones
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Zones
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set map
     *
     * @param \EsterenMaps\MapsBundle\Entity\Maps $map
     * @return Zones
     */
    public function setMap(\EsterenMaps\MapsBundle\Entity\Maps $map = null)
    {
        $this->map = $map;

        return $this;
    }

    /**
     * Get map
     *
     * @return \EsterenMaps\MapsBundle\Entity\Maps
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * Set faction
     *
     * @param \EsterenMaps\MapsBundle\Entity\Factions $faction
     * @return Zones
     */
    public function setFaction(\EsterenMaps\MapsBundle\Entity\Factions $faction = null)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction
     *
     * @return \EsterenMaps\MapsBundle\Entity\Factions
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Add events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsZones $events
     * @return Zones
     */
    public function addEvent(\EsterenMaps\MapsBundle\Entity\EventsZones $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \EsterenMaps\MapsBundle\Entity\EventsZones $events
     */
    public function removeEvent(\EsterenMaps\MapsBundle\Entity\EventsZones $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }
}
