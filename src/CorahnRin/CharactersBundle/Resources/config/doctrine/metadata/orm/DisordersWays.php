<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Entity
 */
class DisordersWays
{
    /**
     * @var \Disorders
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Disorders")
     */
    private $disorder;

    /**
     * @var \Ways
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Ways")
     */
    private $way;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    private $isMajor;


}