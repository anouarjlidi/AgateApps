<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharSocialClass
 *
 * @ORM\Entity
 */
class CharSocialClass
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
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domains1", referencedColumnName="id")
     * })
     */
    private $domain1;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domains2", referencedColumnName="id")
     * })
     */
    private $domain2;

    /**
     * @var \SocialClass
     *
     * @ORM\ManyToOne(targetEntity="SocialClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $socialClass;


}