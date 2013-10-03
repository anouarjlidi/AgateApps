<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharAvtgsRepository")
 */
class CharAvtgs
{
    /**
     * @var \Characters
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Characters", inversedBy="avantages")
     */
    private $character;

    /**
     * @var \Avantages
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Avantages")
     */
    private $avantage;

    /**
     * @var boolean
     *
     * @ORM\Column(type="integer")
     */
    private $doubleValue;



    /**
     * Set doubleValue
     *
     * @param integer $doubleValue
     * @return CharAvtgs
     */
    public function setDoubleValue($doubleValue)
    {
        $this->doubleValue = $doubleValue;
    
        return $this;
    }

    /**
     * Get doubleValue
     *
     * @return integer 
     */
    public function getDoubleValue()
    {
        return $this->doubleValue;
    }

    /**
     * Set character
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $character
     * @return CharAvtgs
     */
    public function setCharacter(\CorahnRin\CharactersBundle\Entity\Characters $character)
    {
        $this->character = $character;
    
        return $this;
    }

    /**
     * Get character
     *
     * @return \CorahnRin\CharactersBundle\Entity\Characters 
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set avantage
     *
     * @param \CorahnRin\CharactersBundle\Entity\Avantages $avantage
     * @return CharAvtgs
     */
    public function setAvantage(\CorahnRin\CharactersBundle\Entity\Avantages $avantage)
    {
        $this->avantage = $avantage;
    
        return $this;
    }

    /**
     * Get avantage
     *
     * @return \CorahnRin\CharactersBundle\Entity\Avantages 
     */
    public function getAvantage()
    {
        return $this->avantage;
    }
}