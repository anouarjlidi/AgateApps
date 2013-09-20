<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineCommonCollectionsCollection as DoctrineCollection;

/**
 * Events
 *
 * @ORM\Entity
 */
class Events
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var \DateTime
	 * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \DateTime
	 * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;



	/**
	 * @var DoctrineCollection
	 * @ORM\ManyToMany(targetEntity="Factions", mappedBy="events")
	 */
	private $factions;

    /**
     * @var DoctrineCollection
     * @ORM\ManyToMany(targetEntity="Foes", mappedBy="events")
     */
    private $foes;

    /**
     * @var DoctrineCollection
     * @ORM\ManyToMany(targetEntity="Npcs", mappedBy="events")
     */
    private $npcs;

    /**
     * @var DoctrineCollection
     * @ORM\ManyToMany(targetEntity="Weather", mappedBy="events")
     */
    private $weather;



    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsMarkers", mappedBy="event")
     */
    private $markers;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsMarkersType", mappedBy="event")
     */
    private $markersType;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsResources", mappedBy="event")
     */
    private $resources;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsRoutes", mappedBy="event")
     */
    private $routes;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsRoutesTypes", mappedBy="event")
     */
    private $routesTypes;

    /**
     * @var DoctrineCollection
     * @ORM\OneToMany(targetEntity="EventsZones", mappedBy="event")
     */
    private $zones;

}