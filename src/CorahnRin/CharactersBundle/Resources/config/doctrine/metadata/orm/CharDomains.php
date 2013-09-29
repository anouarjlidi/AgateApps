<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Entity
 */
class CharDomains
{
    /**
     * @var \Characters
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Characters")
     */
    private $character;

    /**
     * @var \Domains
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Domains")
     */
    private $domain;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $score;


}