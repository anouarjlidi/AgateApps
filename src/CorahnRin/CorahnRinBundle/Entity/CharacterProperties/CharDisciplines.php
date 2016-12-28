<?php

namespace CorahnRin\CorahnRinBundle\Entity\CharacterProperties;

use CorahnRin\CorahnRinBundle\Entity\Characters;
use CorahnRin\CorahnRinBundle\Entity\Disciplines;
use CorahnRin\CorahnRinBundle\Entity\Domains;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharDisciplines.
 *
 * @ORM\Table(name="characters_disciplines")
 * @ORM\Entity()
 */
class CharDisciplines
{
    /**
     * @var Characters
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Characters", inversedBy="disciplines")
     * @Assert\NotNull()
     */
    protected $character;

    /**
     * @var Disciplines
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="CorahnRin\CorahnRinBundle\Entity\Disciplines")
     * @Assert\NotNull()
     */
    protected $discipline;

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
     * @return CharDisciplines
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
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
     * @return CharDisciplines
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set discipline.
     *
     * @param Disciplines $discipline
     *
     * @return CharDisciplines
     *
     * @codeCoverageIgnore
     */
    public function setDiscipline(Disciplines $discipline)
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * Get discipline.
     *
     * @return Disciplines
     *
     * @codeCoverageIgnore
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * Set domain.
     *
     * @param Domains $domain
     *
     * @return CharDisciplines
     *
     * @codeCoverageIgnore
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
     *
     * @codeCoverageIgnore
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
