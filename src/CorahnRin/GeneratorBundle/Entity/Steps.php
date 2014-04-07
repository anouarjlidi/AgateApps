<?php

namespace CorahnRin\GeneratorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Steps
 *
 * @ORM\Table(name="steps")
 * @ORM\Entity(repositoryClass="CorahnRin\GeneratorBundle\Repository\StepsRepository")
 */
class Steps
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
     * @var integer
     *
     * @ORM\Column(type="smallint", nullable=false, unique=true)
     */
    protected $step;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=75, nullable=false)
     */
    protected $title;

    /**
     * @var Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Steps")
     */
    protected $stepsToDisableOnChange;

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
     * Set step
     *
     * @param integer $step
     * @return Steps
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return integer
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Steps
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Steps
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Steps
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
     * @return Steps
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
     * Set deleted
     *
     * @param boolean $deleted
     * @return Steps
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stepsToDisableOnChange = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stepsToDisableOnChange
     *
     * @param Steps $stepsToDisableOnChange
     * @return Steps
     */
    public function addStepToDisableOnChange(Steps $step)
    {
        if ($step->getStep() < $this->step) {
            throw new \Exception('To add a step to disable on update, this step MUST have a "step" value superior to the dependant step.');
        }

        $this->stepsToDisableOnChange[] = $step;

        return $this;
    }

    /**
     * Remove stepsToDisableOnChange
     *
     * @param Steps $stepsToDisableOnChange
     */
    public function removeStepToDisableOnChange(Steps $step)
    {
        $this->stepsToDisableOnChange->removeElement($step);
    }

    /**
     * Get stepsToDisableOnChange
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStepsToDisableOnChange()
    {
        return $this->stepsToDisableOnChange;
    }
}
