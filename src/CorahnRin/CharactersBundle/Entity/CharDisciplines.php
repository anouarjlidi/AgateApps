<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharDisciplines
 *
 * @ORM\Table(name="characters_disciplines")
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharDisciplinesRepository")
 */
class CharDisciplines
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Characters", inversedBy="disciplines")
     */
    protected $character;

    /**
     * @var \DisciplinesDomains
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Disciplines")
     */
    protected $discipline;

    /**
     * @var \Domains
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="Domains")
     */
    protected $domain;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $score;

    /**
     * Set score
     *
     * @param integer $score
     * @return CharDisciplines
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

    /**
     * Set character
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $character
     * @return CharDisciplines
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
     * Set discipline
     *
     * @param \CorahnRin\CharactersBundle\Entity\Disciplines $discipline
     * @return CharDisciplines
     */
    public function setDiscipline(\CorahnRin\CharactersBundle\Entity\Disciplines $discipline)
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * Get discipline
     *
     * @return \CorahnRin\CharactersBundle\Entity\Disciplines
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return CharDisciplines
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

    /**
     * Set domain
     *
     * @param \CorahnRin\CharactersBundle\Entity\Domains $domain
     * @return CharDisciplines
     */
    public function setDomain(\CorahnRin\CharactersBundle\Entity\Domains $domain)
    {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return \CorahnRin\CharactersBundle\Entity\Domains
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
