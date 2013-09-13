<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Routes
 *
 * @ORM\Table(name="routes")
 * @ORM\Entity
 */
class Routes
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
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="idRoutes")
     * @ORM\JoinTable(name="event_routes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_routes", referencedColumnName="id")
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
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="idRoutes")
     */
    private $idResources;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Markers", inversedBy="idRoutes")
     * @ORM\JoinTable(name="routes_markers",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_routes", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_markers", referencedColumnName="id")
     *   }
     * )
     */
    private $idMarkers;

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
     * @var \TypesRoutes
     *
     * @ORM\ManyToOne(targetEntity="TypesRoutes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_types_routes", referencedColumnName="id")
     * })
     */
    private $idTypesRoutes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEvents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idResources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idMarkers = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
