<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Entity\CharacterProperties;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class HealthCondition
{
    /**
     * @var int
     *
     * @ORM\Column(name="good", type="smallint")
     */
    protected $good;

    /**
     * @var int
     *
     * @ORM\Column(name="okay", type="smallint")
     */
    protected $okay;

    /**
     * @var int
     *
     * @ORM\Column(name="bad", type="smallint")
     */
    protected $bad;

    /**
     * @var int
     *
     * @ORM\Column(name="critical", type="smallint")
     */
    protected $critical;

    /**
     * @var int
     *
     * @ORM\Column(name="agony", type="smallint")
     */
    protected $agony;

    public function __construct(int $good = 5, int $okay = 5, int $bad = 4, int $critical = 4, int $agony = 1)
    {
        $this->good = $good;
        $this->okay = $okay;
        $this->bad = $bad;
        $this->critical = $critical;
        $this->agony = $agony;
    }

    /**
     * @return int
     */
    public function getSum()
    {
        return $this->good + $this->okay + $this->bad + $this->critical + ((int) $this->agony);
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getGood(): int
    {
        return $this->good;
    }

    /**
     * @param int $good
     * @return HealthCondition
     *
     * @codeCoverageIgnore
     */
    public function setGood(int $good): HealthCondition
    {
        $this->good = $good;
        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getOkay(): int
    {
        return $this->okay;
    }

    /**
     * @param int $okay
     * @return HealthCondition
     *
     * @codeCoverageIgnore
     */
    public function setOkay(int $okay): HealthCondition
    {
        $this->okay = $okay;
        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getBad(): int
    {
        return $this->bad;
    }

    /**
     * @param int $bad
     * @return HealthCondition
     *
     * @codeCoverageIgnore
     */
    public function setBad(int $bad): HealthCondition
    {
        $this->bad = $bad;
        return $this;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getCritical(): int
    {
        return $this->critical;
    }

    /**
     * @param int $critical
     * @return HealthCondition
     *
     * @codeCoverageIgnore
     */
    public function setCritical(int $critical): HealthCondition
    {
        $this->critical = $critical;
        return $this;
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function isAgony(): bool
    {
        return $this->agony;
    }

    /**
     * @param bool $agony
     * @return HealthCondition
     *
     * @codeCoverageIgnore
     */
    public function setAgony(bool $agony): HealthCondition
    {
        $this->agony = $agony;
        return $this;
    }
}
