<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineCommonCollectionsCollection as DoctrineCollection;

/**
 * Factions
 *
 * @ORM\Entity
 */
class Factions
{
    /**
     * @var integer
     *
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
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="factions")
     */
	private $zones;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="factions")
     */
	private $events;

	/**
	 * @var DoctrineCollection
	 *
	 * @ORM\OneToMany(targetEntity="Routes", mappedBy="faction")
	 */
	private $routes;

	/**
	 * @var DoctrineCollection
	 *
	 * @ORM\OneToMany(targetEntity="Markers", mappedBy="faction")
	 */
	private $markers;
}