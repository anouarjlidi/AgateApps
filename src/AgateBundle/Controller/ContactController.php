<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AgateBundle\Controller;

use AgateBundle\Form\ContactType;
use AgateBundle\Model\ContactMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route(host="%agate_domains.portal%")
 */
class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     */
    public function contactAction(Request $request, $_locale)
    {
        $message = new ContactMessage();
        $message->setLocale($_locale);

        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $translator = $this->get('translator');

            $subject = $translator->trans('form.message_subject', ['%name%' => $message->getName()], 'contact');

            // If message succeeds, we redirect
            if ($this->get('esteren_mailer')->sendContactMail($message, $subject, $request->getClientIp())) {
                $this->addFlash('success', $translator->trans('form.message_sent', [], 'contact'));

                return $this->redirectToRoute('contact');
            }

            // Else, it means transport may had an error or something, so if no exception was thrown, we log this.
            $this->addFlash('error', $translator->trans('form.error', [], 'contact'));
            $this->get('logger')->error('Error when sending email', $this->get('serializer')->serialize($message, 'json'));
        }

        return $this->render('@Agate/contact.html.twig', [
            'form'       => $form->createView(),
            'mail_error' => $form->getErrors(true, true)->count(),
        ]);
    }
}
