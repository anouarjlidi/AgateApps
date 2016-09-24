<?php

namespace Esteren\PortalBundle\Model;

class ContactMessage
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return ContactMessage
     */
    public function setName($name)
    {
        $this->name = strip_tags((string) $name);

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return ContactMessage
     */
    public function setSubject($subject)
    {
        $this->subject = strip_tags((string) $subject);

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return ContactMessage
     */
    public function setEmail($email)
    {
        $this->email = strip_tags((string) $email);

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return ContactMessage
     */
    public function setMessage($message)
    {
        $this->message = strip_tags((string) $message);

        return $this;
    }
}
