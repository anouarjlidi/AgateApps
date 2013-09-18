<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineCommonCollectionsCollection as DoctrineCollection;

/**
 * EventsResources
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EventsResources
{
    /**
     * @var \Events
     *
     * @ORM\Column(type="integer", length=255, nullable=false)
     */
    private $event;
	
    /**
     * @var \Resources
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     */
    private $resource;

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