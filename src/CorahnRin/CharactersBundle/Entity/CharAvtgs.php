<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Table(name="characters_avantages")
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
    protected $character;

    /**
     * @var \Avantages
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Avantages")
     */
    protected $avantage;

    /**
     * @var boolean
     *
     * @ORM\Column(type="integer")
     */
    protected $doubleValue;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
     */
    protected $deleted;

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

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return CharAvtgs
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
