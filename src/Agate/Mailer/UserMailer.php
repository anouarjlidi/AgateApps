<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\Mailer;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;
use Agate\Entity\User;

final class UserMailer
{
    private $twig;
    private $mailer;
    private $router;
    private $sender;
    private $translator;

    public function __construct(RequestStack $requestStack, \Swift_Mailer $mailer, Environment $twig, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->sender     = 'no-reply@'.($requestStack->getMasterRequest() ? $requestStack->getMasterRequest()->getHost() : 'studio-agate.com');
        $this->twig       = $twig;
        $this->mailer     = $mailer;
        $this->router     = $router;
        $this->translator = $translator;
    }

    public function sendRegistrationEmail(User $user)
    {
        $url = $this->router->generate('user_registration_confirm', ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $rendered = $this->twig->render('user/Registration/email.html.twig', [
            'user'            => $user,
            'confirmationUrl' => $url,
        ]);

        $message = new \Swift_Message();

        $message
            ->setSubject($this->translator->trans('registration.email.subject', ['%username%' => $user->getUsername()], 'user'))
            ->setFrom($this->sender)
            ->setContentType('text/html')
            ->setTo($user->getEmail())
            ->setBody($rendered)
        ;

        $this->mailer->send($message);
    }

    public function sendResettingEmailMessage(User $user): void
    {
        $url = $this->router->generate('user_resetting_reset', ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $rendered = $this->twig->render('user/Resetting/email.txt.twig', [
            'user'            => $user,
            'confirmationUrl' => $url,
        ]);

        $this->sendEmailMessage($rendered, (string) $user->getEmail());
    }

    private function sendEmailMessage(string $renderedTemplate, string $toEmail): void
    {
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject       = array_shift($renderedLines);
        $body          = implode("\n", $renderedLines);

        $message = new \Swift_Message();

        $message
            ->setSubject($subject)
            ->setFrom($this->sender)
            ->setTo($toEmail)
            ->setBody($body)
        ;

        $this->mailer->send($message);
    }
}
