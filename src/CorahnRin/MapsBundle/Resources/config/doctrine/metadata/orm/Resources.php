<?php

namespace CorahnRin\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection as DoctrineCollection;

/**
 * Resources
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Resources
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
     * @ORM\ManyToMany(targetEntity="Routes", inversedBy="resources")
     */
    private $routes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\ManyToMany(targetEntity="RoutesTypes", inversedBy="resources")
     */
    private $routesTypes;

    /**
     * @var DoctrineCollection
     *
     * @ORM\OneToMany(targetEntity="EventsResources", mappedBy="resource")
     */
	private $events;
}