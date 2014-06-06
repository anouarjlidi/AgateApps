<?php

namespace CorahnRin\CharactersBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * CharFlux
 *
 * @ORM\Table(name="characters_flux")
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharFluxRepository")
 */
class CharFlux
{
    /**
     * @var Characters
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Characters", inversedBy="flux")
     */
    protected $character;

    /**
     * @var Flux
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Flux")
     */
    protected $flux;

    /**
     * @var integer
     *
     * @ORM\Column(type="smallint")
     */
    protected $quantity;

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
     * @param Characters $character
     * @return CharFlux
     */
    public function setCharacter(Characters $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return Characters
     */
    public function getCharacter()
    {
        return $this->character;
    }
}
