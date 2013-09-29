<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Weapons
 *
 * @ORM\Entity
 */
class Weapons
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $dmg;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=3, nullable=false)
     */
    private $availability;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $contact;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $range;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Characters", mappedBy="Weapons")
     */
    private $Characters;

}