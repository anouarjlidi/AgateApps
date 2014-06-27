<?php

namespace CorahnRin\ModelsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MailsSent
 *
 * @ORM\Table(name="mails_sent")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\ModelsBundle\Repository\MailsSentRepository")
 */
class MailsSent {

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $toName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $toEmail;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $subject;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $content;

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
     * @var Mails
     *
     * @ORM\ManyToOne(targetEntity="Mails")
     */
    protected $mail;

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
     * Set toName
     *
     * @param string $toName
     * @return MailsSent
     */
    public function setToName($toName) {
        $this->toName = $toName;

        return $this;
    }

    /**
     * Get toName
     *
     * @return string
     */
    public function getToName() {
        return $this->toName;
    }

    /**
     * Set toEmail
     *
     * @param string $toEmail
     * @return MailsSent
     */
    public function setToEmail($toEmail) {
        $this->toEmail = $toEmail;

        return $this;
    }

    /**
     * Get toEmail
     *
     * @return string
     */
    public function getToEmail() {
        return $this->toEmail;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return MailsSent
     */
    public function setSubject($subject) {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return MailsSent
     */
    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return MailsSent
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
     * @return MailsSent
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
     * Set mail
     *
     * @param Mails $mail
     * @return MailsSent
     */
    public function setMail(Mails $mail = null) {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return Mails
     */
    public function getMail() {
        return $this->mail;
    }

    /**
     * Set deleted
     *
     * @param \DateTime $deleted
     * @return MailsSent
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