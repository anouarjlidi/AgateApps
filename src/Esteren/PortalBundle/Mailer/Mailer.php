<?php

namespace Esteren\PortalBundle\Mailer;

use Esteren\PortalBundle\Model\ContactMessage;
use Symfony\Bundle\TwigBundle\TwigEngine;

final class Mailer
{
    /**
     * @var TwigEngine
     */
    private $templating;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, TwigEngine $templating)
    {
        $this->templating = $templating;
        $this->mailer = $mailer;
    }

    /**
     * @param ContactMessage $message
     * @param string         $ip
     *
     * @return int
     */
    public function sendContactMail(ContactMessage $message, $ip = null)
    {
        $swiftMessage = new \Swift_Message();

        $swiftMessage
            ->setSubject($message->getSubject())
            ->setFrom($message->getEmail())
            ->setTo('pierstoval+esterenportal@gmail.com')
            ->setBody($this->templating->render('@EsterenPortal/email/contact_email.html.twig', [
                'ip'      => $ip,
                'message' => $message,
            ]))
        ;

        return $this->mailer->send($swiftMessage);
    }
}
