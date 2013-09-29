<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MailsSent
 *
 * @ORM\Entity
 */
class MailsSent
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
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $toName;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $toEmail;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $date;

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
     * @var \Mails
     *
     * @ORM\ManyToOne(targetEntity="Mails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(referencedColumnName="id")
     * })
     */
    private $Mails;



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
     * Set toName
     *
     * @param string $toName
     * @return MailsSent
     */
    public function setToName($toName)
    {
        $this->toName = $toName;
    
        return $this;
    }

    /**
     * Get toName
     *
     * @return string 
     */
    public function getToName()
    {
        return $this->toName;
    }

    /**
     * Set toEmail
     *
     * @param string $toEmail
     * @return MailsSent
     */
    public function setToEmail($toEmail)
    {
        $this->toEmail = $toEmail;
    
        return $this;
    }

    /**
     * Get toEmail
     *
     * @return string 
     */
    public function getToEmail()
    {
        return $this->toEmail;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return MailsSent
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    
        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return MailsSent
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return MailsSent
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set dateCreated
     *
     * @param integer $dateCreated
     * @return MailsSent
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
     * @return MailsSent
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
     * Set Mails
     *
     * @param \CorahnRin\CharactersBundle\Entity\Mails $mails
     * @return MailsSent
     */
    public function setMails(\CorahnRin\CharactersBundle\Entity\Mails $mails = null)
    {
        $this->Mails = $mails;
    
        return $this;
    }

    /**
     * Get Mails
     *
     * @return \CorahnRin\CharactersBundle\Entity\Mails 
     */
    public function getMails()
    {
        return $this->Mails;
    }
}