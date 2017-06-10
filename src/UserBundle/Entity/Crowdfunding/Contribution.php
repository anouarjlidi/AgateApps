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
use UserBundle\Entity\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="cf_contributions", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_contribution_id_and_type", columns={"id", "type"})
 * })
 */
class Contribution
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="contributions")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     */
    private $user;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Crowdfunding\Project")
     * @ORM\JoinColumn(name="project_id", nullable=false)
     */
    private $project;

    /**
     * @var Reward[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="UserBundle\Entity\Crowdfunding\Reward", cascade={"persist"})
     * @ORM\JoinTable(name="cf_user_contributions_rewards")
     */
    private $rewards;

    public function __construct(int $id, string $type)
    {
        $this->id = $id;
        $this->type = $type;
        $this->rewards = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }


    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        $user->addContribution($this);

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
     * @return Reward[]|ArrayCollection
     */
    public function getRewards()
    {
        return $this->rewards;
    }

    public function addReward(Reward $reward): self
    {
        $this->rewards[] = $reward;

        return $this;
    }

    public function removeReward(Reward $reward): self
    {
        $this->rewards->removeElement($reward);

        return $this;
    }

    public function resetRewards(): self
    {
        $this->rewards = new ArrayCollection();

        return $this;
    }
}
