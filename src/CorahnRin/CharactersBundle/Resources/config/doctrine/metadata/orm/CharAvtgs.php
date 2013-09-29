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
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Characters")
     */
    private $character;

    /**
     * @var \Avdesv
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Avdesv")
     */
    private $avdesv;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $isDoubled;


}