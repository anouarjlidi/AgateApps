<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineCommonCollectionsCollection as DoctrineCollection;

/**
 * EventsRoutesTypes
 *
 * @ORM\Entity
 */
class EventsRoutesTypes {

    /**
     * @var \Events
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="routesTypes")
     */
    private $event;

    /**
     * @var \RoutesTypes
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="RoutesTypes", inversedBy="events")
     */
    private $route_type;

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