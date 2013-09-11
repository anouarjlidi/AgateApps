<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * MailsSent
 *
 * @ORM\Table(name="mails_sent")
 * @ORM\Entity
 */
class MailsSent
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
     * @ORM\Column(name="to_name", type="string", length=255, nullable=false)
     */
    private $toName;

    /**
     * @var string
     *
     * @ORM\Column(name="to_email", type="string", length=255, nullable=false)
     */
    private $toEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="text", nullable=false)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=50, nullable=false)
     */
    private $date;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_created", type="datetime", nullable=false)
     */
    private $dateCreated;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date_updated", type="datetime", nullable=false)
     */
    private $dateUpdated;

    /**
     * @var \Mails
     *
     * @ORM\ManyToOne(targetEntity="Mails")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_mails", referencedColumnName="id")
     * })
     */
    private $idMails;


}
