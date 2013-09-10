<?php

namespace CorahnRin\PagessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pages
 *
 * @ORM\Table(name="pages")
 * @ORM\Entity
 */
class Pages
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=30, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=75, nullable=false)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_in_admin", type="boolean", nullable=false)
     */
    private $showInAdmin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_in_menu", type="boolean", nullable=false)
     */
    private $showInMenu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="require_login", type="boolean", nullable=false)
     */
    private $requireLogin;

    /**
     * @var integer
     *
     * @ORM\Column(name="date_created", type="integer", nullable=false)
     */
    private $dateCreated;

    /**
     * @var integer
     *
     * @ORM\Column(name="date_updated", type="integer", nullable=false)
     */
    private $dateUpdated;


}