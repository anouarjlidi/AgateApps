<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventsRoutes
 *
 * @ORM\Table(name="event_routes")
 * @ORM\Entity
 */
class EventsRoutes {
    /**
     * @var \Events
     *
     * @ORM\Column(name="id_events", type="integer", length=255, nullable=false)
     */
    private $event;
	
    /**
     * @var \Routes
     *
     * @ORM\Column(name="id_routes", type="integer", nullable=false)
     * @ORM\Id
     */
    private $route;

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
	 * @var smallint
	 * 
	 * @ORM\Column(name="percentage", type="smallint", nullable=false)
	 */
	private $percentage;
}
