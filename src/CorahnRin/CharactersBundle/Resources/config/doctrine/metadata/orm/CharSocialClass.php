<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * CharSocialClass
 *
 * @ORM\Table(name="char_social_class")
 * @ORM\Entity
 */
class CharSocialClass
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
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domains1", referencedColumnName="id")
     * })
     */
    private $idDomains1;

    /**
     * @var \Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_domains2", referencedColumnName="id")
     * })
     */
    private $idDomains2;

    /**
     * @var \SocialClass
     *
     * @ORM\ManyToOne(targetEntity="SocialClass")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_social_class", referencedColumnName="id")
     * })
     */
    private $idSocialClass;


}
