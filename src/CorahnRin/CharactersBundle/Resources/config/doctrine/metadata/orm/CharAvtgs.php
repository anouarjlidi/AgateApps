<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Entity
 */
class CharAvtgs
{
    /**
     * @var \Characters
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Characters")
     */
    private $character;

    /**
     * @var \Avantage
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Avantage")
     */
    private $avantage;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $isDoubled;


}