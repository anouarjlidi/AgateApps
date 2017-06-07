<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esteren\PortalBundle\Model;

class ContactMessage
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $message = '';

    /**
     * @var string
     */
    private $locale = 'fr';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ContactMessage
    {
        $this->name = strip_tags((string) $name);

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): ContactMessage
    {
        $this->email = strip_tags((string) $email);

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): ContactMessage
    {
        $this->message = strip_tags((string) $message);

        return $this;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): ContactMessage
    {
        $this->locale = $locale;

        return $this;
    }
}
