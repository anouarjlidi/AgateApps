<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineCommonCollectionsCollection as DoctrineCollection;

/**
 * Events
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Events
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
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
     * @ORM\ManyToMany(targetEntity="Foes", mappedBy="events")
     */
    private $foes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="MarkersType", mappedBy="events")
     */
    private $markersType;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Markers", mappedBy="events")
     */
    private $markers;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Npcs", mappedBy="events")
     */
    private $npcs;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="events")
     */
    private $resources;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Routes", mappedBy="events")
     */
    private $routes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="RoutesTypes", mappedBy="events")
     */
    private $routesTypes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Weather", mappedBy="events")
     */
    private $weather;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Zones", mappedBy="events")
     */
    private $zones;

	/**
	 * @var DoctrineCollection
	 * 
	 * @ORM\ManyToMany(targetEntity="Factions", mappedBy="events")
	 */
	private $factions;

}