<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Table(name="char_disciplines")
 * @ORM\Entity
 */
class CharDisciplines
{
    /**
     * @var \Characters
     *
     * @ORM\Column(name="id_characters", type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Characters")
     */
    private $character;

    /**
     * @var \Disciplines
     *
     * @ORM\Column(name="id_disciplines", type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Disciplines")
     */
    private $discipline;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;


    /**
     * Set character
     *
     * @param integer $character
     * @return CharDisciplines
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
     * Set discipline
     *
     * @param integer $discipline
     * @return CharDisciplines
     */
    public function setDiscipline($discipline)
    {
        $this->discipline = $discipline;
    
        return $this;
    }

    /**
     * Get discipline
     *
     * @return integer 
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return CharDisciplines
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