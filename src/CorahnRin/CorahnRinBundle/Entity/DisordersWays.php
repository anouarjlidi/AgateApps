<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DisordersWays.
 *
 * @ORM\Table(name="disorders_ways")
 * @ORM\Entity()
 */
class DisordersWays
{
    /**
     * @var Disorders
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Disorders", inversedBy="ways")
     */
    protected $disorder;

    /**
     * @var Ways
     *
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Ways")
     */
    protected $way;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    protected $major = 0;

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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * Set isMajor.
     *
     * @param bool $major
     *
     * @return DisordersWays
     *
     * @codeCoverageIgnore
     */
    public function setMajor($major)
    {
        $this->major = $major;

        return $this;
    }

    /**
     * Get isMajor.
     *
     * @return bool
     */
    public function isMajor()
    {
        return $this->major;
    }
}
