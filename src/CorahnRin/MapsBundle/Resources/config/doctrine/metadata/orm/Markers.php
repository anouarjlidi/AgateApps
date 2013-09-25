<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * Markers
 *
 * @ORM\Entity
 */
class Markers
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $coordinates;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
     *
	 * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Routes", mappedBy="markers")
     */
    private $routes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="Factions", inversedBy="markers")
     */
    private $faction;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="Maps", inversedBy="markers")
     */
    private $map;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToOne(targetEntity="MarkersTypes", inversedBy="markers")
     */
    private $markerType;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="EventsMarkers", mappedBy="marker")
     */
    private $events;
}