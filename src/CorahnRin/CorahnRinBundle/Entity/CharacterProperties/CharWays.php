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

use CorahnRin\CorahnRinBundle\Entity\Characters;
use CorahnRin\CorahnRinBundle\Entity\Ways;
use Doctrine\ORM\Mapping as ORM;

/**
 * CharWays.
 *
 * @ORM\Table(name="characters_ways")
 * @ORM\Entity()
 */
class CharWays
{
    /**
     * @var Characters
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Characters", inversedBy="ways")
     */
    protected $character;

    /**
     * @var Ways
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Ways")
     */
    protected $way;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $score;

    /**
     * Set character.
     *
     * @param Characters $character
     *
     * @return CharWays
     */
    public function setCharacter(Characters $character)
    {
        $this->character = $character;

        if (!$character->getWay($this->way->getShortName())) {
            $character->addWay($this);
        }

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
     * Set way.
     *
     * @param Ways $way
     *
     * @return CharWays
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
     * Set score.
     *
     * @param int $score
     *
     * @return CharWays
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
}
