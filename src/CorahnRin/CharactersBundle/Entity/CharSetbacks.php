<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharSetbacks
 *
 * @ORM\Table(name="characters_setbacks")
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharSetbacksRepository")
 */
class CharSetbacks
{
    /**
     * @var \Characters
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Characters", inversedBy="setbacks")
     */
    protected $character;

    /**
     * @var \Setbacks
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Setbacks")
     */
    protected $setback;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $isAvoided;

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
