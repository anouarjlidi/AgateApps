<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventsZones
 *
 * @ORM\Table(name="event_zones")
 * @ORM\Entity
 */
class EventsZones {
    /**
     * @var \Events
     *
     * @ORM\Column(name="id_events", type="integer", length=255, nullable=false)
     */
    private $event;
	
    /**
     * @var \Zones
     *
     * @ORM\Column(name="id_zones", type="integer", nullable=false)
     * @ORM\Id
     */
    private $zone;

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
