<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Entity
 */
class CharWays
{
    /**
     * @var \Characters
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Characters")
     */
    private $character;

    /**
     * @var \Ways
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Ways")
     */
    private $way;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $score;



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
}