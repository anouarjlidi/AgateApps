<?php

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
     * @param int $character
     *
     * @return CharWays
     */
    public function setCharacter($character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character.
     *
     * @return int
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
     * Set score.
     *
     * @param int $score
     *
     * @return CharWays
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
     */
    public function getScore()
    {
        return $this->score;
    }
}
