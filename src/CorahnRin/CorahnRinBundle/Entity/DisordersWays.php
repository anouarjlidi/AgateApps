<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * DisordersWays.
 *
 * @ORM\Table(name="disorders_ways")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 */
class DisordersWays
{
    /**
     * @var Disorders
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Disorders", inversedBy="ways")
     */
    protected $disorder;

    /**
     * @var Ways
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ways")
     */
    protected $way;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":0})
     */
    protected $isMajor = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted;

    public function __toString()
    {
        return $this->disorder->getName().' - '.$this->way->getName();
    }

    /**
     * Set disorder.
     *
     * @param Disorders $disorder
     *
     * @return DisordersWays
     */
    public function setDisorder(Disorders $disorder)
    {
        $this->disorder = $disorder;

        return $this;
    }

    /**
     * Get disorder.
     *
     * @return Disorders
     */
    public function getDisorder()
    {
        return $this->disorder;
    }

    /**
     * Set way.
     *
     * @param Ways $way
     *
     * @return DisordersWays
     */
    public function setWay(Ways $way)
    {
        $this->way = $way;

        return $this;
    }

    /**
     * Get way.
     *
     * @return Ways
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * Set isMajor.
     *
     * @param bool $isMajor
     *
     * @return DisordersWays
     */
    public function setIsMajor($isMajor)
    {
        $this->isMajor = $isMajor;

        return $this;
    }

    /**
     * Get isMajor.
     *
     * @return bool
     */
    public function isMajor()
    {
        return $this->isMajor;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return DisordersWays
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return \DateTime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
