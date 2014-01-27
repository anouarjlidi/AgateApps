<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharModifications
 *
 * @ORM\Table(name="characters_modifications")
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\CharModificationsRepository")
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
    protected $id;

    /**
     * @var \Characters
     *
     * @ORM\Column(type="object", nullable=false)
     */
    protected $before;

    /**
     * @var \Characters
     *
     * @ORM\ManyToOne(targetEntity="Characters", inversedBy="modifications")
     */
    protected $character;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\UsersBundle\Entity\Users")
     */
    protected $user;

    /**
     * @var \Datetime
     * @Gedmo\Mapping\Annotation\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime

     * @Gedmo\Mapping\Annotation\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=false,options={"default":0})
     */
    protected $deleted;

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
     * Set before
     *
     * @param \stdClass $before
     * @return CharModifications
     */
    public function setBefore($before)
    {
        $this->before = $before;

        return $this;
    }

    /**
     * Get before
     *
     * @return \stdClass
     */
    public function getBefore()
    {
        return $this->before;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CharModifications
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return CharModifications
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set character
     *
     * @param \CorahnRin\CharactersBundle\Entity\Characters $character
     * @return CharModifications
     */
    public function setCharacter(\CorahnRin\CharactersBundle\Entity\Characters $character = null)
    {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return \CorahnRin\CharactersBundle\Entity\Characters
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set user
     *
     * @param \CorahnRin\UsersBundle\Entity\Users $user
     * @return CharModifications
     */
    public function setUser(\CorahnRin\UsersBundle\Entity\Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CorahnRin\UsersBundle\Entity\Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return CharModifications
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
