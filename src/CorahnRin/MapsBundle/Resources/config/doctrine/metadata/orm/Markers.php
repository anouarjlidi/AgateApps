<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Markers
 *
 * @ORM\Table(name="markers")
 * @ORM\Entity
 */
class Markers
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
     * @var string
     *
     * @ORM\Column(name="coordinates", type="text", nullable=false)
     */
    private $coordinates;

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
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="idMarkers")
     * @ORM\JoinTable(name="event_markers",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_markers", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_events", referencedColumnName="id")
     *   }
     * )
     */
    private $idEvents;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Routes", mappedBy="idMarkers")
     */
    private $idRoutes;

    /**
     * @var \Factions
     *
     * @ORM\ManyToOne(targetEntity="Factions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_factions", referencedColumnName="id")
     * })
     */
    private $idFactions;

    /**
     * @var \Maps
     *
     * @ORM\ManyToOne(targetEntity="Maps")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_maps", referencedColumnName="id")
     * })
     */
    private $idMaps;

    /**
     * @var \MarkersType
     *
     * @ORM\ManyToOne(targetEntity="MarkersType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_markers_type", referencedColumnName="id")
     * })
     */
    private $idMarkersType;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEvents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idRoutes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
