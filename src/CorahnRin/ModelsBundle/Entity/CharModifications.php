<?php

namespace CorahnRin\ModelsBundle\Entity;

use CorahnRin\UsersBundle\Entity\Users;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * CharModifications
 *
 * @ORM\Table(name="characters_modifications")
 * @ORM\Entity(repositoryClass="CorahnRin\ModelsBundle\Repository\CharModificationsRepository")
 */
class CharModifications {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\NotNull()
     */
    protected $id;

    /**
     * @var Characters
     *
     * @ORM\Column(type="object", nullable=false)
     */
    protected $before;

    /**
     * @var Characters
     *
     * @ORM\ManyToOne(targetEntity="Characters", inversedBy="modifications")
     */
    protected $character;

    /**
     * @var Users
     *
     * @ORM\ManyToOne(targetEntity="CorahnRin\UsersBundle\Entity\Users")
     */
    protected $user;

    /**
     * @var \Datetime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $created;

    /**
     * @var \Datetime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param integer $id
     * @return $this
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * Set before
     *
     * @param \stdClass $before
     * @return CharModifications
     */
    public function setBefore($before) {
        $this->before = $before;

        return $this;
    }

    /**
     * Get before
     *
     * @return \stdClass
     */
    public function getBefore() {
        return $this->before;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CharModifications
     */
    public function setCreated($created) {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated() {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return CharModifications
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Set character
     *
     * @param Characters $character
     * @return CharModifications
     */
    public function setCharacter(Characters $character = null) {
        $this->character = $character;

        return $this;
    }

    /**
     * Get character
     *
     * @return Characters
     */
    public function getCharacter() {
        return $this->character;
    }

    /**
     * Set user
     *
     * @param Users $user
     * @return CharModifications
     */
    public function setUser(Users $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Users
     */
    public function getUser() {
        return $this->user;
    }


    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return CharModifications
     */
    public function setDeleted($deleted) {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return \DateTime
     */
    public function getDeleted() {
        return $this->deleted;
    }
}
