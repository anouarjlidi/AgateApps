<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Miracles
 *
 * @ORM\Entity
 */
class Miracles
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
     * @ORM\Column(type="string", length=70, nullable=false)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $isMajor;

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
     * @ORM\ManyToMany(targetEntity="Characters", inversedBy="Miracles")
     * @ORM\JoinTable(name="char_miracles",
     *   joinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   }
     * )
     */
    private $Characters;

}