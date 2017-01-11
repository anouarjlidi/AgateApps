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

        if ($form->isSubmitted() && $form->isValid() && $this->get('esteren_mailer')->sendContactMail($message, $request->getClientIp())) {
            /** @var Session $session */
            $session = $request->getSession();
            $session->getFlashBag()->add('success', $this->get('translator')->trans('contact.message_sent'));

            return $this->redirectToRoute('contact');
        }

        return $this->render('@EsterenPortal/contact.html.twig', [
            'form'       => $form->createView(),
            'mail_error' => $form->getErrors(true, true)->count(),
        ]);
    }
}
