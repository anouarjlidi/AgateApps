<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RoutesTypes
 *
 * @ORM\Table(name="routes_types")
 * @ORM\Entity
 */
class RoutesTypes
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
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="idTypesRoutes")
     * @ORM\JoinTable(name="event_types_routes",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_types_routes", referencedColumnName="id")
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
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="idTypesRoutes")
     */
    private $idResources;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEvents = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idResources = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
