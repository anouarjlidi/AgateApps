<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * MailsSent.
 *
 * @ORM\Table(name="mails_sent")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 */
class MailsSent
{
    /**
     * @var int
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
     * @var \DateTime
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted;

    /**
     * Get id.
     *
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set toName.
     *
     * @param string $toName
     *
     * @return MailsSent
     *
     * @codeCoverageIgnore
     */
    public function setToName($toName)
    {
        $this->toName = $toName;

        return $this;
    }

    /**
     * Get toName.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getToName()
    {
        return $this->toName;
    }

    /**
     * Set toEmail.
     *
     * @param string $toEmail
     *
     * @return MailsSent
     *
     * @codeCoverageIgnore
     */
    public function setToEmail($toEmail)
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    /**
     * Get toEmail.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getToEmail()
    {
        return $this->toEmail;
    }

    /**
     * Set subject.
     *
     * @param string $subject
     *
     * @return MailsSent
     *
     * @codeCoverageIgnore
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return MailsSent
     *
     * @codeCoverageIgnore
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return MailsSent
     *
     * @codeCoverageIgnore
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     *
     * @codeCoverageIgnore
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return MailsSent
     *
     * @codeCoverageIgnore
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     *
     * @codeCoverageIgnore
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set mail.
     *
     * @param Mails $mail
     *
     * @return MailsSent
     *
     * @codeCoverageIgnore
     */
    public function setMail(Mails $mail = null)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail.
     *
     * @return Mails
     *
     * @codeCoverageIgnore
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Set deleted.
     *
     * @param \DateTime $deleted
     *
     * @return MailsSent
     *
     * @codeCoverageIgnore
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted.
     *
     * @return \DateTime
     *
     * @codeCoverageIgnore
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
