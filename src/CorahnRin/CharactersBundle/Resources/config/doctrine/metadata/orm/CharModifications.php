<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharModifications
 *
 * @ORM\Entity
 */
class CharModifications
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
     * @ORM\Column(type="text", nullable=false)
     */
    private $contentBefore;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $contentAfter;

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
     * @var \Characters
     *
     * @ORM\ManyToOne(targetEntity="Characters")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $character;

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