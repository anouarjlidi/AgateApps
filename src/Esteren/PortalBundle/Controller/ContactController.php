<?php

namespace Esteren\PortalBundle\Controller;

use Esteren\PortalBundle\Form\ContactType;
use Esteren\PortalBundle\Model\ContactMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Session $session */
            $session = $request->getSession();
            $flashBag = $session->getFlashBag();

            $translator = $this->get('translator');

            $subject = $translator->trans('form.message_subject', ['%name%' => $message->getName()], 'contact');

            // If message succeeds, we redirect
            if ($this->get('esteren_mailer')->sendContactMail($message, $subject, $request->getClientIp())) {
                $flashBag->add('success', $translator->trans('form.message_sent', [], 'contact'));

                return $this->redirectToRoute('contact');
            }

            // Else, it means transport may had an error or something, so if no exception was thrown, we log this.
            $flashBag->add('error', $translator->trans('form.error', [], 'contact'));
            $this->get('logger')->error('Error when sending email', $this->get('jms_serializer')->serialize($message, 'json'));
        }

        return $this->render('@EsterenPortal/contact.html.twig', [
            'form'       => $form->createView(),
            'mail_error' => $form->getErrors(true, true)->count(),
        ]);
    }
}
