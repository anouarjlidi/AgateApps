<?php

namespace CorahnRin\CharactersBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharWays
 *
 * @ORM\Table(name="characters_ways")
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharWaysRepository")
 */
class CharWays
{
    /**
     * @var Characters
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Characters", inversedBy="ways")
     * @Assert\NotNull()
     */
    protected $character;

    /**
     * @var Ways
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Ways")
     * @Assert\NotNull()
     */
    protected $way;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $score;

    /**
     * Set character
     *
     * @param integer $character
     * @return CharWays
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
     * Set way
     *
     * @param integer $way
     * @return CharWays
     */
    public function setWay($way)
    {
        $this->way = $way;

        return $this;
    }

    /**
     * Get way
     *
     * @return integer
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return CharWays
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore()
    {
        return $this->score;
    }
}
