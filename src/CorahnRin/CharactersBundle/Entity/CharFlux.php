<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Table(name="char_flux")
 * @ORM\Entity
 */
class CharFlux
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
     * @var \Flux
     *
     * @ORM\Column(name="id_avdesv", type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Flux")
     */
    private $flux;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;


    /**
     * Set character
     *
     * @param integer $character
     * @return CharFlux
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
     * Set flux
     *
     * @param integer $flux
     * @return CharFlux
     */
    public function setFlux($flux)
    {
        $this->flux = $flux;
    
        return $this;
    }

    /**
     * Get flux
     *
     * @return integer 
     */
    public function getFlux()
    {
        return $this->flux;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return CharFlux
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
}