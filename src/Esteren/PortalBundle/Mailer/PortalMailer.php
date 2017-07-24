<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esteren\PortalBundle\Mailer;

use AgateBundle\Model\ContactMessage;
use Symfony\Component\Templating\EngineInterface;

final class PortalMailer
{
    private $templating;
    private $mailer;

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->templating = $templating;
        $this->mailer     = $mailer;
    }

    /**
     * @param ContactMessage $message
     * @param string         $subject
     * @param string         $ip
     *
     * @return int
     */
    public function sendContactMail(ContactMessage $message, $subject, $ip = null)
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
            ->setBody($body = $this->templating->render('@Agate/email/contact_email.html.twig', [
                'ip'      => $ip,
                'message' => $message,
            ]))
        ;

        return $this->mailer->send($swiftMessage);
    }
}
