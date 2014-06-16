<?php

namespace CorahnRin\ModelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * DisordersWays
 *
 * @ORM\Table(name="disorders_ways")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\ModelsBundle\Repository\DisordersWaysRepository")
 */
class DisordersWays {

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
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default":0})
     */
    protected $isMajor = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    function __toString() {
        return $this->disorder->getName().' - '.$this->way->getName();
    }

    /**
     * Set disorder
     *
     * @param integer $disorder
     * @return DisordersWays
     */
    public function setDisorder($disorder) {
        $this->disorder = $disorder;

        return $this;
    }

    /**
     * Get disorder
     *
     * @return integer
     */
    public function getDisorder() {
        return $this->disorder;
    }

    /**
     * Set way
     *
     * @param integer $way
     * @return DisordersWays
     */
    public function setWay($way) {
        $this->way = $way;

        return $this;
    }

    /**
     * Get way
     *
     * @return integer
     */
    public function getWay() {
        return $this->way;
    }

    /**
     * Set isMajor
     *
     * @param boolean $isMajor
     * @return DisordersWays
     */
    public function setIsMajor($isMajor) {
        $this->isMajor = $isMajor;

        return $this;
    }

    /**
     * Get isMajor
     *
     * @return boolean
     */
    public function getIsMajor() {
        return $this->isMajor;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return DisordersWays
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted() {
        return $this->deleted;
    }
}
