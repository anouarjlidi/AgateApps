<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MarkersType
 *
 * @ORM\Table(name="markers_type")
 * @ORM\Entity
 */
class MarkersType
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
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="idMarkersType")
     * @ORM\JoinTable(name="event_marker_types",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_markers_type", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_events", referencedColumnName="id")
     *   }
     * )
     */
    private $idEvents;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idEvents = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
}
