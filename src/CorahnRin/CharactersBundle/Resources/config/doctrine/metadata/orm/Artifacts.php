<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Artifacts
 *
 * @ORM\Entity
 */
class Artifacts
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
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $consumptionValue;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $consumptionInterval;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $tank;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $resistance;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=70, nullable=false)
     */
    private $vulnerability;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $handling;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $damage;

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
     * @ORM\ManyToMany(targetEntity="Characters", mappedBy="Artifacts")
     */
    private $Characters;

    /**
     * @var \Flux
     *
     * @ORM\ManyToOne(targetEntity="Flux")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $Flux;

}