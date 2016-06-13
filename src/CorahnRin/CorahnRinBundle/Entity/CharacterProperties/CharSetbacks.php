<?php

namespace CorahnRin\CorahnRinBundle\Entity\CharacterProperties;

use CorahnRin\CorahnRinBundle\Entity\Characters;
use CorahnRin\CorahnRinBundle\Entity\Setbacks;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharSetbacks.
 *
 * @ORM\Table(name="characters_setbacks")
 * @ORM\Entity()
 */
class CharSetbacks
{
    /**
     * @var Characters
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Characters", inversedBy="setbacks")
     * @Assert\NotNull()
     */
    protected $character;

    /**
     * @var Setbacks
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Setbacks")
     * @Assert\NotNull()
     */
    protected $setback;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isAvoided = false;

    /**
     * Set character.
     *
     * @param int $character
     *
     * @return CharSetbacks
     */
    public function setCharacter($character)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character.
     *
     * @return int
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set setback.
     *
     * @param int $setback
     *
     * @return CharSetbacks
     */
    public function setSetback($setback)
    {
        $this->setback = $setback;

        return $this;
    }

    /**
     * Get setback.
     *
     * @return int
     */
    public function getSetback()
    {
        return $this->setback;
    }

    /**
     * Set isAvoided.
     *
     * @param bool $isAvoided
     *
     * @return CharSetbacks
     */
    public function setIsAvoided($isAvoided)
    {
        $this->isAvoided = $isAvoided;

        return $this;
    }

    /**
     * Get isAvoided.
     *
     * @return bool
     */
    public function getIsAvoided()
    {
        return $this->isAvoided;
    }
}
