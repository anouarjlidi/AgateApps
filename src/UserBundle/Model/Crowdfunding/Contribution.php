<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Model\Crowdfunding;

use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\User;

class Contribution
{
    private $id;
    private $type;
    private $user;
    private $project;
    private $rewards;

    public function __construct(array $data)
    {
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

    public function getProject(): Project
    {
        return $this->project;
    }

    /**
     * @return Reward[]|ArrayCollection
     */
    public function getRewards()
    {
        return $this->rewards;
    }
}
