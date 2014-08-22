<?php

namespace Application\Sonata\PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Sonata\PageBundle\Entity\BaseSnapshot as BaseSnapshot;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Characters
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity()
 * @ORM\Table(name="page__snapshot")
 */
class Snapshot extends BaseSnapshot
{

    /**
     * @var integer
     * @ORM\Column(type="integer", name="id", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Datetime
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * Get id
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Datetime
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param \Datetime $deleted
     * @return $this
     */
    public function setDeleted(\Datetime $deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }
}