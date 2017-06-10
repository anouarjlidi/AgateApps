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

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cf_reward_variants", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_variant_id_and_type", columns={"id", "type"})
 * })
 */
class RewardVariant
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
     * @ORM\Column(name="description", type="text", nullable=false)
     */
    private $description;

    /**
     * @var Reward
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Crowdfunding\Reward", inversedBy="variants")
     * @ORM\JoinColumn(name="reward_id", nullable=false)
     */
    private $reward;

    public function __construct(int $id, string $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getReward(): Reward
    {
        return $this->reward;
    }

    public function setReward(Reward $reward): self
    {
        $this->reward = $reward;

        return $this;
    }
}
