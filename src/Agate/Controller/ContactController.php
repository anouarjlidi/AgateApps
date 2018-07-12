<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\Controller;

use Agate\Form\ContactType;
use Agate\Model\ContactMessage;
use Agate\Mailer\PortalMailer;
use ReCaptcha\ReCaptcha;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;
use Main\PublicService;

/**
 * @Route(host="%agate_domains.portal%")
 */
class ContactController implements PublicService
{
    private $mailer;
    private $reCaptcha;
    private $translator;
    private $twig;
    private $formFactory;
    private $router;

    public function __construct(
        PortalMailer $mailer,
        ReCaptcha $reCaptcha,
        TranslatorInterface $translator,
        Environment $twig,
        FormFactoryInterface $formFactory,
        RouterInterface $router
    ) {
        $this->mailer = $mailer;
        $this->reCaptcha = $reCaptcha;
        $this->translator = $translator;
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->router = $router;
    }

    /**
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     */
    public function contactAction(Request $request, Session $session, $_locale)
    {
        $message = new ContactMessage();
        $message->setLocale($_locale);

        $form = $this->formFactory->create(ContactType::class, $message);
        $form->handleRequest($request);

        $captcha = $request->request->get('g-recaptcha-response');

        if ($captcha && false === $this->reCaptcha->verify($captcha, $request->getClientIp())->isSuccess()) {
            $form->addError(new FormError('Invalid captcha'));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $translator = $this->translator;

            $subject = $translator->trans('form.message_subject', [
                '%name%' => $message->getName(),
                '%subject%' => strip_tags($message->getSubject())
            ], 'contact');

            // If message succeeds, we redirect
            if ($this->mailer->sendContactMail($message, $subject, $request->getClientIp())) {
                $session->getFlashBag()->add('success', $translator->trans('form.message_sent', [], 'contact'));

                return new RedirectResponse($this->router->generate('contact'));
            }

            // Else, it means transport may had an error or something, so if no exception was thrown, we log this.
            $form->addError(new FormError($translator->trans('form.error', [], 'contact')));
        }

        return new Response($this->twig->render('agate/contact.html.twig', [
            'form'       => $form->createView(),
            'mail_error' => $form->getErrors(true, true),
        ]));
    }
}
