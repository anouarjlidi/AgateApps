<?php

namespace CorahnRin\CorahnRinBundle\Entity\CharacterProperties;

use CorahnRin\CorahnRinBundle\Entity\Characters;
use CorahnRin\CorahnRinBundle\Entity\Domains;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharDomains.
 *
 * @ORM\Table(name="characters_domains")
 * @ORM\Entity()
 */
class CharDomains
{
    /**
     * @var Characters
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Characters", inversedBy="domains")
     * @Assert\NotNull()
     */
    protected $character;

    /**
     * @var Domains
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Domains")
     * @Assert\NotNull()
     */
    protected $domain;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $score;

    /**
     * Set score.
     *
     * @param int $score
     *
     * @return CharDomains
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score.
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set character.
     *
     * @param Characters $character
     *
     * @return CharDomains
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
     * Set domain.
     *
     * @param Domains $domain
     *
     * @return CharDomains
     */
    public function setDomain(Domains $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain.
     *
     * @return Domains
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
