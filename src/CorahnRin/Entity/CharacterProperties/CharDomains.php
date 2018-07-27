<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Entity\CharacterProperties;

use CorahnRin\Entity\Characters;
use CorahnRin\Entity\Domains;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharDomains.
 *
 * @ORM\Table(name="characters_domains")
 * @ORM\Entity
 */
class CharDomains
{
    /**
     * @var Characters
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\Entity\Characters", inversedBy="domains")
     * @Assert\NotNull
     */
    protected $character;

    /**
     * @var Domains
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\Entity\Domains")
     * @Assert\NotNull
     */
    protected $domain;

    /**
     * @var int
     *
     * @ORM\Column(name="score", type="smallint")
     * @Assert\NotNull
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $score;

    /**
     * @var int
     *
     * @ORM\Column(name="bonus", type="smallint", options={"default" = 0})
     */
    protected $bonus = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="malus", type="smallint", options={"default" = 0})
     */
    protected $malus = 0;

    /**
     * Set score.
     *
     * @param int $score
     *
     * @return CharDomains
     *
     * @codeCoverageIgnore
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score.
     *
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return int
     */
    public function getBonus()
    {
        return $this->bonus;
    }

    /**
     * @param int $bonus
     *
     * @return CharDomains
     */
    public function setBonus($bonus)
    {
        $this->bonus = $bonus;

        return $this;
    }

    /**
     * @return int
     */
    public function getMalus()
    {
        return $this->malus;
    }

    /**
     * @param int $malus
     *
     * @return CharDomains
     */
    public function setMalus($malus)
    {
        $this->malus = $malus;

        return $this;
    }

    /**
     * Set character.
     *
     * @param Characters $character
     *
     * @return CharDomains
     *
     * @codeCoverageIgnore
     */
    public function setCharacter(Characters $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character.
     *
     * @return Characters
     *
     * @codeCoverageIgnore
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set domain.
     *
     * @param Domains $domain
     *
     * @return CharDomains
     *
     * @codeCoverageIgnore
     */
    public function setDomain(Domains $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain.
     *
     * @return Domains
     *
     * @codeCoverageIgnore
     */
    public function getDomain()
    {
        return $this->domain;
    }

    public function getTotalScore(): int
    {
        return $this->score + $this->character->getWay($this->getDomain()->getWay());
    }
}
