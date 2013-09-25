<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * EventsMarkersTypes
 *
 * @ORM\Entity
 */
class EventsMarkersTypes {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="markersTypes")
     */
    private $event;

    /**
     * @var \MarkersTypes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="MarkersTypes", inversedBy="events")
     */
    private $markerType;

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