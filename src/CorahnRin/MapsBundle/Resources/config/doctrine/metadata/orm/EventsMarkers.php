<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineCommonCollectionsCollection as DoctrineCollection;

/**
 * EventsMarkers
 *
 * @ORM\Entity
 */
class EventsMarkers {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="markers")
     */
    private $event;

    /**
     * @var \Markers
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Markers", inversedBy="events")
     */
    private $marker;

	/**
	 * @var smallint
	 *
	 * @ORM\Column(type="smallint", nullable=false)
	 */
	private $percentage;

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

}