<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Traits
 *
 * @ORM\Table(name="traits")
 * @ORM\Entity
 */
class Traits
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="name_female", type="string", length=50, nullable=false)
     */
    private $nameFemale;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_quality", type="boolean", nullable=false)
     */
    private $isQuality;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_major", type="boolean", nullable=false)
     */
    private $isMajor;

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
     * @var \Ways
     *
     * @ORM\ManyToOne(targetEntity="Ways")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ways", referencedColumnName="id")
     * })
     */
    private $idWays;


}
