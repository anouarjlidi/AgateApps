<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Entity
 */
class CharAvtgs
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
     * @var \Avdesv
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Avdesv")
     */
    private $avdesv;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $isDoubled;


    /**
     * Set character
     *
     * @param integer $character
     * @return CharAvtgs
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
     * Set avdesv
     *
     * @param integer $avdesv
     * @return CharAvtgs
     */
    public function setAvdesv($avdesv)
    {
        $this->avdesv = $avdesv;
    
        return $this;
    }

    /**
     * Get avdesv
     *
     * @return integer 
     */
    public function getAvdesv()
    {
        return $this->avdesv;
    }

    /**
     * Set isDoubled
     *
     * @param boolean $isDoubled
     * @return CharAvtgs
     */
    public function setIsDoubled($isDoubled)
    {
        $this->isDoubled = $isDoubled;
    
        return $this;
    }

    /**
     * Get isDoubled
     *
     * @return boolean 
     */
    public function getIsDoubled()
    {
        return $this->isDoubled;
    }
}