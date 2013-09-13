<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Resources
 *
 * @ORM\Table(name="resources")
 * @ORM\Entity
 */
class Resources
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
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="idResources")
     * @ORM\JoinTable(name="event_resources",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_resources", referencedColumnName="id")
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
     * @ORM\ManyToMany(targetEntity="Routes", inversedBy="idResources")
     * @ORM\JoinTable(name="resource_routes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_resources", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_routes", referencedColumnName="id")
     *   }
     * )
     */
    private $idRoutes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TypesRoutes", inversedBy="idResources")
     * @ORM\JoinTable(name="resource_types_route",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_resources", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_types_routes", referencedColumnName="id")
     *   }
     * )
     */
    private $idTypesRoutes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEvents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idRoutes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idTypesRoutes = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
