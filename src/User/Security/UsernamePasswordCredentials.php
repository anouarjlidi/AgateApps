<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace User\Security;

final class UsernamePasswordCredentials
{
    /**
     * @var string
     */
    private $usernameOrEmail;

    /**
     * @var string
     */
    private $password;

    /**
     * @param string $usernameOrEmail
     * @param string $password
     */
    public function __construct($usernameOrEmail, $password)
    {
        $this->usernameOrEmail = $usernameOrEmail;
        $this->password        = $password;
    }

    /**
     * @return string
     */
    public function getUsernameOrEmail()
    {
        return $this->usernameOrEmail;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
