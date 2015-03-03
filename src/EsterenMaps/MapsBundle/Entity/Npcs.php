<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * Npcs
 *
 * @ORM\Table(name="maps_npcs")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity()
 */
class Npcs
{

    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var Events[]
     * @ORM\ManyToMany(targetEntity="Events", inversedBy="npcs")
     */
    protected $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Npcs
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add events
     *
     * @param Events $events
     *
     * @return Npcs
     */
    public function addEvent(Events $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param Events $events
     */
    public function removeEvent(Events $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return Events[]
     */
    public function getEvents()
    {
        return $this->events;
    }

}
