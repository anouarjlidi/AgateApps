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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=30, nullable=false)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=75, nullable=false)
     */
    protected $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_in_admin", type="boolean", nullable=false)
     */
    protected $showInAdmin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_in_menu", type="boolean", nullable=false)
     */
    protected $showInMenu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="require_login", type="boolean", nullable=false)
     */
    protected $requireLogin;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    protected $dateCreated;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=false)
     */
    protected $dateUpdated;


}