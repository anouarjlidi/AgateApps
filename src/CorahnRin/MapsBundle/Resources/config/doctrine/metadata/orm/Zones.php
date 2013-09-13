<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zones
 *
 * @ORM\Table(name="zones")
 * @ORM\Entity
 */
class Zones
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
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="idZones")
     * @ORM\JoinTable(name="event_zones",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_zones", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_events", referencedColumnName="id")
     *   }
     * )
     */
    private $idEvents;

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
     * Constructor
     */
    public function __construct()
    {
        $this->idEvents = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
