<?php

namespace CorahnRin\ModelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CharWays
 *
 * @ORM\Table(name="characters_ways")
 * @ORM\Entity(repositoryClass="CorahnRin\ModelsBundle\Repository\CharWaysRepository")
 */
class CharWays {
    /**
     * @var Characters
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Characters", inversedBy="ways")
     */
    protected $character;

    /**
     * @var Ways
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ways")
     */
    protected $way;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $score;

    /**
     * Set character
     *
     * @param integer $character
     * @return CharWays
     */
    public function setCharacter($character) {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return integer
     */
    public function getCharacter() {
        return $this->character;
    }

    /**
     * Set way
     *
     * @param Ways $way
     * @return CharWays
     */
    public function setWay(Ways $way) {
        $this->way = $way;

        return $this;
    }

    /**
     * Get way
     *
     * @return Ways
     */
    public function getWay() {
        return $this->way;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return CharWays
     */
    public function setScore($score) {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore() {
        return $this->score;
    }
}
