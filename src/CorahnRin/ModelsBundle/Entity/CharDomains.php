<?php

namespace CorahnRin\ModelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharDomains
 *
 * @ORM\Table(name="characters_domains")
 * @ORM\Entity()
 */
class CharDomains {

    /**
     * @var Characters
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Characters", inversedBy="domains")
     * @Assert\NotNull()
     */
    protected $character;

    /**
     * @var Domains
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Domains")
     * @Assert\NotNull()
     */
    protected $domain;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value=0)
     */
    protected $score;

    /**
     * Set score
     *
     * @param integer $score
     * @return CharDomains
     */
    public function setScore($score) {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return integer
     */
    public function getScore() {
        return $this->score;
    }

    /**
     * Set character
     *
     * @param Characters $character
     * @return CharDomains
     */
    public function setCharacter(Characters $character) {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return Characters
     */
    public function getCharacter() {
        return $this->character;
    }

    /**
     * Set domain
     *
     * @param Domains $domain
     * @return CharDomains
     */
    public function setDomain(Domains $domain) {
        $this->domain = $domain;

        return $this;
    }

    /**
     * Get domain
     *
     * @return Domains
     */
    public function getDomain() {
        return $this->domain;
    }
}
