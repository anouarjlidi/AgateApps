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

use Agate\Model\ContactMessage;
use Twig\Environment;

final class PortalMailer
{
    private $twig;
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function sendContactMail(ContactMessage $message, string $subject, string $ip = null): int
    {
        $swiftMessage = new \Swift_Message();

        $swiftMessage
            ->setSubject($subject)
            ->setContentType('text/html')
            ->setCharset('utf-8')
            ->setFrom($message->getEmail())
            ->setTo('pierstoval+newportal@gmail.com')
            ->addCc('cindy.studioagate+portal@gmail.com', 'Cindy Husson')
            ->addCc('nelyhann+portal@gmail.com', 'Les Ombres d\'Esteren')
            ->setBody($this->twig->render('agate/email/contact_email.html.twig', [
                'ip' => $ip,
                'message' => $message,
            ]))
        ;

        return $this->mailer->send($swiftMessage);
    }
}
