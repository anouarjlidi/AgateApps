<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharAvtgs.
 *
 * @ORM\Table(name="characters_avantages")
 * @ORM\Entity()
 */
class CharAvtgs
{
    /**
     * @var Characters
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Characters", inversedBy="avantages")
     * @Assert\NotNull()
     */
    protected $character;

    /**
     * @var Avantages
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Avantages")
     * @Assert\NotNull()
     */
    protected $avantage;

    /**
     * @var bool
     *
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $doubleValue;

    /**
     * Set doubleValue.
     *
     * @param int $doubleValue
     *
     * @return CharAvtgs
     */
    public function setDoubleValue($doubleValue)
    {
        $this->doubleValue = $doubleValue;

        return $this;
    }

    /**
     * Get doubleValue.
     *
     * @return int
     */
    public function getDoubleValue()
    {
        return $this->doubleValue;
    }

    /**
     * Set character.
     *
     * @param Characters $character
     *
     * @return CharAvtgs
     */
    public function setCharacter(Characters $character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character.
     *
     * @return Characters
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set avantage.
     *
     * @param Avantages $avantage
     *
     * @return CharAvtgs
     */
    public function setAvantage(Avantages $avantage)
    {
        $this->avantage = $avantage;

        return $this;
    }

    /**
     * Get avantage.
     *
     * @return Avantages
     */
    public function getAvantage()
    {
        return $this->avantage;
    }
}
