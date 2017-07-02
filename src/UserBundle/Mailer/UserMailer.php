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

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;
use UserBundle\Entity\User;

final class UserMailer
{
    private $templating;
    private $mailer;
    private $router;
    private $sender;
    private $translator;

    public function __construct(RequestStack $requestStack, \Swift_Mailer $mailer, EngineInterface $templating, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->sender     = 'no-reply@'.$requestStack->getMasterRequest()->getHost();
        $this->templating = $templating;
        $this->mailer     = $mailer;
        $this->router     = $router;
        $this->translator = $translator;
    }

    public function sendRegistrationEmail(User $user)
    {
        $url = $this->router->generate('user_registration_confirm', ['token' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $rendered = $this->templating->render('@User/Registration/email.html.twig', [
            'user'            => $user,
            'confirmationUrl' => $url,
        ]);

        $message = new \Swift_Message();

        $message
            ->setSubject($this->translator->trans('registration.email.subject', ['%username%' => $user->getUsername()], 'UserBundle'))
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

        $rendered = $this->templating->render('@User/Resetting/email.txt.twig', [
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
