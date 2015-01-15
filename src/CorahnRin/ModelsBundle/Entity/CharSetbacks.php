<?php

namespace CorahnRin\ModelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharSetbacks
 *
 * @ORM\Table(name="characters_setbacks")
 * @ORM\Entity()
 */
class CharSetbacks {

    /**
     * @var Characters
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Characters", inversedBy="setbacks")
     * @Assert\NotNull()
     */
    protected $character;

    /**
     * @var Setbacks
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Setbacks")
     * @Assert\NotNull()
     */
    protected $setback;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $isAvoided = false;

    /**
     * Set character
     *
     * @param integer $character
     * @return CharSetbacks
     */
    public function setCharacter($character) {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return integer
     */
    public function getCharacter() {
        return $this->character;
    }

    /**
     * Set setback
     *
     * @param integer $setback
     * @return CharSetbacks
     */
    public function setSetback($setback) {
        $this->setback = $setback;

        return $this;
    }

    /**
     * Get setback
     *
     * @return integer
     */
    public function getSetback() {
        return $this->setback;
    }

    /**
     * Set isAvoided
     *
     * @param boolean $isAvoided
     * @return CharSetbacks
     */
    public function setIsAvoided($isAvoided) {
        $this->isAvoided = $isAvoided;

        return $this;
    }

    /**
     * Get isAvoided
     *
     * @return boolean
     */
    public function getIsAvoided() {
        return $this->isAvoided;
    }
}
