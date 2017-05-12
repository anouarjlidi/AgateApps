<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Mailer;

use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use UserBundle\Entity\User;

final class UserMailer
{
    private $templating;
    private $mailer;
    private $router;
    private $sender;

    public function __construct(string $sender, \Swift_Mailer $mailer, TwigEngine $templating, RouterInterface $router)
    {
        $this->sender = $sender;
        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function sendResettingEmailMessage(User $user): void
    {
        $url = $this->router->generate('user_resetting_reset', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
        $rendered = $this->templating->render('@User/Resetting/email.txt.twig', array(
            'user' => $user,
            'confirmationUrl' => $url,
        ));

        $this->sendEmailMessage($rendered, (string) $user->getEmail());
    }

    private function sendEmailMessage(string $renderedTemplate, string $toEmail): void
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = array_shift($renderedLines);
        $body = implode("\n", $renderedLines);

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($this->sender)
            ->setTo($toEmail)
            ->setBody($body)
        ;

        $this->mailer->send($message);
    }
}
