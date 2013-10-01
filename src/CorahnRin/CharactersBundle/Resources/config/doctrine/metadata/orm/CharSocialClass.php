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
     * @var \Characters
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Characters", inversedBy="markers")
     */
    private $character;

    /**
     * @var \SocialClass
     *
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="SocialClass")
     */
    private $socialClass;

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
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    private $domain1;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    private $domain2;


}