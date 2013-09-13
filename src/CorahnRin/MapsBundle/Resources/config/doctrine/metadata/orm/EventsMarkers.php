<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EventsMarkers
 *
 * @ORM\Table(name="event_markers")
 * @ORM\Entity
 */
class EventsMarkers {
    /**
     * @var \Events
     *
     * @ORM\Column(name="id_events", type="integer", length=255, nullable=false)
     */
    private $event;
	
    /**
     * @var \Markers
     *
     * @ORM\Column(name="id_markers", type="integer", nullable=false)
     * @ORM\Id
     */
    private $marker;

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
