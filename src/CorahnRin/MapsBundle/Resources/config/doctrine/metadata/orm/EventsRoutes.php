<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineCommonCollectionsCollection as DoctrineCollection;

/**
 * EventsRoutes
 *
 * @ORM\Entity
 */
class EventsRoutes {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="routes")
     */
    private $event;

    /**
     * @var \Routes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Routes", inversedBy="events")
     */
    private $route;

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
	 * @var smallint
	 *
	 * @ORM\Column(type="smallint", nullable=false)
	 */
	private $percentage;

}