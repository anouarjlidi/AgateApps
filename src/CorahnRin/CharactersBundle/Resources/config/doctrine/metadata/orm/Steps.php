<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Steps
 *
 * @ORM\Table(name="steps")
 * @ORM\Entity
 */
class Steps
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
     * @ORM\Column(name="step", type="integer", nullable=false)
     */
    private $step;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=75, nullable=false)
     */
    private $title;

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


}
