<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharFluxRepository")
 */
class CharFlux
{
    /**
     * @var \Characters
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Characters", inversedBy="flux")
     */
    private $character;

    /**
     * @var \Flux
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Flux")
     */
    private $flux;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $quantity;



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

    /**
     * Set character
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $character
     * @return CharFlux
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
}
