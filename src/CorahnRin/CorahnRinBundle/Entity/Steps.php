<?php

namespace CorahnRin\CorahnRinBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Steps.
 *
 * @ORM\Table(name="steps")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\StepsRepository")
 */
class Steps
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
     * @var int
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
     * @var Steps[]
     *
     * @ORM\ManyToMany(targetEntity="Steps")
     */
    protected $stepsToDisableOnChange;

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
     * @var bool
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set step.
     *
     * @param int $step
     *
     * @return Steps
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step.
     *
     * @return int
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Steps
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Steps
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Steps
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
     * @return Steps
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
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->stepsToDisableOnChange = new ArrayCollection();
    }

    /**
     * Add stepsToDisableOnChange.
     *
     * @param Steps $step
     *
     * @throws \Exception
     *
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
     * Remove stepsToDisableOnChange.
     *
     * @param Steps $step
     */
    public function removeStepToDisableOnChange(Steps $step)
    {
        $this->stepsToDisableOnChange->removeElement($step);
    }

    /**
     * Get stepsToDisableOnChange.
     *
     * @return Steps[]
     */
    public function getStepsToDisableOnChange()
    {
        return $this->stepsToDisableOnChange;
    }
}
