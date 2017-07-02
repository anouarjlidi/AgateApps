<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\ConnectApi\Model;

final class UluleUser
{
    private $id;
    private $username;

    public function __construct(array $clientResult)
    {
        $this->id       = $clientResult['id'];
        $this->username = $clientResult['username'];
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }
}
