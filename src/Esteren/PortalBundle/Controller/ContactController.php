<?php

namespace Esteren\PortalBundle\Controller;

use Esteren\PortalBundle\Form\ContactType;
use Esteren\PortalBundle\Model\ContactMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {
        $message = new ContactMessage();
        $form    = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        $mailError = null;

        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject($message->getSubject())
                ->setFrom($message->getEmail())
                ->setTo('pierstoval+esterenportal@gmail.com')
                ->setBody(
                    $this->renderView(
                        '@EsterenPortal/email/contact_email.html.twig',
                        [
                            'ip'      => $request->getClientIp(),
                            'name'    => $message->getName(),
                            'message' => $message->getMessage(),
                        ]
                    )
                )
            ;

            if ($this->get('mailer')->send($message)) {
                $request->getSession()->getFlashBag()->add('success', $this->get('translator')
                    ->trans('contact.message_sent'))
                ;

                return $this->redirect($this->generateUrl('contact'));
            }

            $mailError = true;
        }

        return $this->render('@EsterenPortal/contact.html.twig', [
            'form'       => $form->createView(),
            'mail_error' => $mailError,
        ]);
    }
}
