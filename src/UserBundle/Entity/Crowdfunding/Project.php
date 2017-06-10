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
 * @ORM\Entity(repositoryClass="UserBundle\Repository\Crowdfunding\ProjectRepository")
 * @ORM\Table(name="cf_projects", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_project_id_and_type", columns={"id", "type"})
 * })
 */
class Project
{
    const ULULE = 'ulule';

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var Reward[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="UserBundle\Entity\Crowdfunding\Reward", mappedBy="project")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return ArrayCollection|Reward[]
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

    public function getRewardById(int $id): ?Reward
    {
        foreach ($this->rewards as $reward) {
            if ($reward->getId() === $id) {
                return $reward;
            }
        }

        return null;
    }
}
