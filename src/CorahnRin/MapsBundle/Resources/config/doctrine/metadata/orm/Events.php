<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="events")
 * @ORM\Entity
 */
class Events
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_modified", type="datetime", nullable=false)
     */
    private $dateModified;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Foes", mappedBy="idEvents")
     */
    private $idFoes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="MarkersType", mappedBy="idEvents")
     */
    private $idMarkersType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Markers", mappedBy="idEvents")
     */
    private $idMarkers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Npcs", mappedBy="idEvents")
     */
    private $idNpcs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="idEvents")
     */
    private $idResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Routes", mappedBy="idEvents")
     */
    private $idRoutes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TypesRoutes", mappedBy="idEvents")
     */
    private $idTypesRoutes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Weather", inversedBy="idEvents")
     * @ORM\JoinTable(name="event_weather",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_events", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_weather", referencedColumnName="id")
     *   }
     * )
     */
    private $idWeather;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Zones", mappedBy="idEvents")
     */
    private $idZones;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idFoes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idMarkersType = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idMarkers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idNpcs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idRoutes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idTypesRoutes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idWeather = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idZones = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
