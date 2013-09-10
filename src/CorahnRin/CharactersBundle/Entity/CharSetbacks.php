<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Table(name="char_setbacks")
 * @ORM\Entity
 */
class CharSetbacks
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
     * @var \Setbacks
     *
     * @ORM\Column(name="id_setbacks", type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Setbacks")
     */
    private $setback;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_doubled", type="boolean")
     */
    private $isAvoided;


    /**
     * Set character
     *
     * @param integer $character
     * @return CharSetbacks
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
     * Set setback
     *
     * @param integer $setback
     * @return CharSetbacks
     */
    public function setSetback($setback)
    {
        $this->setback = $setback;
    
        return $this;
    }

    /**
     * Get setback
     *
     * @return integer 
     */
    public function getSetback()
    {
        return $this->setback;
    }

    /**
     * Set isAvoided
     *
     * @param boolean $isAvoided
     * @return CharSetbacks
     */
    public function setIsAvoided($isAvoided)
    {
        $this->isAvoided = $isAvoided;
    
        return $this;
    }

    /**
     * Get isAvoided
     *
     * @return boolean 
     */
    public function getIsAvoided()
    {
        return $this->isAvoided;
    }
}