<?php

namespace CorahnRin\CharactersBundle\Entity;

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

    /**
     * @var \Groups
     *
     * @ORM\ManyToOne(targetEntity="Groups")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_groups", referencedColumnName="id")
     * })
     */
    private $Groups;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Pages
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Pages
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set showInAdmin
     *
     * @param boolean $showInAdmin
     * @return Pages
     */
    public function setShowInAdmin($showInAdmin)
    {
        $this->showInAdmin = $showInAdmin;
    
        return $this;
    }

    /**
     * Get showInAdmin
     *
     * @return boolean 
     */
    public function getShowInAdmin()
    {
        return $this->showInAdmin;
    }

    /**
     * Set showInMenu
     *
     * @param boolean $showInMenu
     * @return Pages
     */
    public function setShowInMenu($showInMenu)
    {
        $this->showInMenu = $showInMenu;
    
        return $this;
    }

    /**
     * Get showInMenu
     *
     * @return boolean 
     */
    public function getShowInMenu()
    {
        return $this->showInMenu;
    }

    /**
     * Set requireLogin
     *
     * @param boolean $requireLogin
     * @return Pages
     */
    public function setRequireLogin($requireLogin)
    {
        $this->requireLogin = $requireLogin;
    
        return $this;
    }

    /**
     * Get requireLogin
     *
     * @return boolean 
     */
    public function getRequireLogin()
    {
        return $this->requireLogin;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return Pages
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    
        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return integer 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param integer $dateUpdated
     * @return Pages
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    
        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return integer 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set Groups
     *
     * @param \CorahnRin\CharactersBundle\Entity\Groups $groups
     * @return Pages
     */
    public function setGroups(\CorahnRin\CharactersBundle\Entity\Groups $groups = null)
    {
        $this->Groups = $groups;
    
        return $this;
    }

    /**
     * Get Groups
     *
     * @return \CorahnRin\CharactersBundle\Entity\Groups 
     */
    public function getGroups()
    {
        return $this->Groups;
    }
}