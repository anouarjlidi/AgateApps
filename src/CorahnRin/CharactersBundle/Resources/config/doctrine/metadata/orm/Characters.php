<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Characters
 *
 * @ORM\Entity
 */
class Characters
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
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1, nullable=false)
     */
    private $sex;

    /**
     * @var string
     *
     * @ORM\Column(type="array", nullable=false)
     */
    private $inventory;

    /**
     * @var string
     *
     * @ORM\Column(type="array", nullable=false)
     */
    private $money;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=30, nullable=false)
     */
    private $orientation;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=25, nullable=false)
     */
    private $geoLiving;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $age;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $mentalResist;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $health;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $stamina;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $survival;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $speed;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $defense;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $rindath;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $exaltation;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $experienceActual;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     */
    private $experienceSpent;

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
     * @ORM\ManyToMany(targetEntity="Armors", inversedBy="Characters")
     * @ORM\JoinTable(name="char_armors",
     *   joinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   }
     * )
     */
    private $Armors;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Artifacts", inversedBy="Characters")
     * @ORM\JoinTable(name="char_artifacts",
     *   joinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   }
     * )
     */
    private $Artifacts;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Avdesv", mappedBy="Characters")
     */
    private $Avdesv;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Miracles", mappedBy="Characters")
     */
    private $Miracles;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ogham", inversedBy="Characters")
     * @ORM\JoinTable(name="char_ogham",
     *   joinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   }
     * )
     */
    private $Ogham;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Weapons", inversedBy="Characters")
     * @ORM\JoinTable(name="char_weapons",
     *   joinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(referencedColumnName="id")
     *   }
     * )
     */
    private $Weapons;

    /**
     * @var \CharSocialClass
     *
     * @ORM\ManyToOne(targetEntity="CharSocialClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $CharSocialClass;

    /**
     * @var \Disorders
     *
     * @ORM\ManyToOne(targetEntity="Disorders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $disorder;

    /**
     * @var \Jobs
     *
     * @ORM\ManyToOne(targetEntity="Jobs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $job;

    /**
     * @var \Regions
     *
     * @ORM\ManyToOne(targetEntity="Regions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $region;

    /**
     * @var \Traits
     *
     * @ORM\ManyToOne(targetEntity="Traits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $traitFlaw;

    /**
     * @var \Traits
     *
     * @ORM\ManyToOne(targetEntity="Traits")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $traitQuality;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\UsersBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $user;

}