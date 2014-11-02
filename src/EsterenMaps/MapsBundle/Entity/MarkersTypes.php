<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as Serializer;

/**
 * MarkersType
 *
 * @ORM\Table(name="markers_types")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\MarkersTypesRepository")
 * @Serializer\ExclusionPolicy("all")
 * @Gedmo\Uploadable(allowOverwrite=true, filenameGenerator="SHA1")
 */
class MarkersTypes
{

    /**
     * @var integer
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
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     * @Serializer\Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\UploadableFilePath()
     * @Serializer\Expose
     */
    protected $iconName;

    /** @var array */
    protected $iconDimensions = null;

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
     * @var EventsMarkersTypes[]
     *
     * @ORM\OneToMany(targetEntity="EventsMarkersTypes", mappedBy="markerType")
     */
    protected $events;

    /**
     * @var Markers[]
     *
     * @ORM\OneToMany(targetEntity="Markers", mappedBy="markerType")
     */
    protected $markers;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    public function __toString()
    {
        return $this->id . ' - ' . $this->name;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
        $this->markers = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return MarkersTypes
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
     * Set created
     *
     * @param \DateTime $created
     * @return MarkersTypes
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
     * @return MarkersTypes
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
     * Add events
     *
     * @param EventsMarkersTypes $events
     * @return MarkersTypes
     */
    public function addEvent(EventsMarkersTypes $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param EventsMarkersTypes $events
     */
    public function removeEvent(EventsMarkersTypes $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return EventsMarkersTypes[]
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add markers
     *
     * @param Markers $markers
     * @return MarkersTypes
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
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return MarkersTypes
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
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
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getIconName()
    {
        if (!$this->iconDimensions) {
            $this->setIconDimensions();
        }
        return $this->iconName;
    }

    /**
     * @param string $iconName
     * @return $this
     */
    public function setIconName($iconName)
    {
        $this->iconName = $iconName;
        if (!$this->iconDimensions) {
            $this->setIconDimensions();
        }
        return $this;
    }

    /**
     * Récupère la largeur et la hauteur de l'image dans un array
     *
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("iconDimensions")
     * @Serializer\Type("array")
     *
     * @link http://php.net/manual/fr/function.getimagesize.php
     * @return string
     */
    public function getIconDimensions()
    {
        if ($this->iconDimensions) {
            return $this->iconDimensions;
        } else {
            return $this->setIconDimensions();
        }
    }

    /**
     * @return array
     */
    private function setIconDimensions()
    {
        if (!$this->iconDimensions) {
            $info = $this->iconName ? getimagesize($this->iconName) : array(null,null);
            $this->iconDimensions = array(
                'width' => isset($info[0]) ? $info[0] : null,
                'height' => isset($info[1]) ? $info[1] : null,
            );
        }
        return $this->iconDimensions;
    }
}
