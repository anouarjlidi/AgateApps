<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharWays
 *
 * @ORM\Table(name="characters_ways")
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharWaysRepository")
 */
class CharWays
{
    /**
     * @var \Characters
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Characters", inversedBy="ways")
     */
    protected $character;

    /**
     * @var \Ways
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
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
     */
    protected $deleted;

    /**
     * Set character
     *
     * @param integer $character
     * @return CharWays
     */
    public function setCharacter($character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return integer
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set way
     *
     * @param integer $way
     * @return CharWays
     */
    public function setWay($way)
    {
        $this->way = $way;

        return $this;
    }

    /**
     * Get way
     *
     * @return integer
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return CharWays
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return CharWays
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
