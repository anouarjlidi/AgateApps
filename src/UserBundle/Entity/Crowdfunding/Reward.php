<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Entity\Crowdfunding;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cf_rewards", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_reward_id_and_type", columns={"id", "type"})
 * })
 */
class Reward
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=15, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Crowdfunding\Project", inversedBy="rewards")
     * @ORM\JoinColumn(name="project_id", nullable=false)
     */
    private $project;

    /**
     * @var RewardVariant[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Crowdfunding\RewardVariant", mappedBy="reward", cascade={"all"})
     */
    private $variants;

    public function __construct(int $id, string $type)
    {
        $this->id = $id;
        $this->type = $type;
        $this->variants = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getProject(): Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return ArrayCollection|RewardVariant[]
     */
    public function getVariants()
    {
        return $this->variants;
    }

    public function addVariant(RewardVariant $variant): self
    {
        $this->variants[] = $variant;

        return $this;
    }

    public function removeVariant(RewardVariant $variant): self
    {
        $this->variants->removeElement($variant);

        return $this;
    }

    public function getVariantById(string $id): ?RewardVariant
    {
        foreach ($this->variants as $variant) {
            if ($variant->getId() === $id) {
                return $variant;
            }
        }

        return null;
    }
}
