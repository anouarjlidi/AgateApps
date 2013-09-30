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
     * @ORM\Column(type="string", length=70, nullable=false, unique=true)
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
     * @ORM\Column(type="integer", nullable=false)
     */
    private $consumption;

    /**
     * @var integer
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
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $created;

    /**
     * @var \Datetime

     * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $updated;

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