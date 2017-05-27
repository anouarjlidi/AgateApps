<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Translation\TranslatorInterface;
use UserBundle\ConnectApi\UluleClient;
use UserBundle\Util\Canonicalizer;
use UserBundle\Entity\User;

class ProfileFormType extends AbstractType
{
    private $canonicalizer;
    private $ululeClient;
    private $translator;

    public function __construct(Canonicalizer $canonicalizer, UluleClient $ululeClient, TranslatorInterface $translator)
    {
        $this->canonicalizer = $canonicalizer;
        $this->ululeClient = $ululeClient;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var User $user */
        $user = $builder->getData();

        $builder
            ->add('username', TextType::class, [
                'label'              => 'form.username',
                'translation_domain' => 'UserBundle',
            ])
            ->add('email', EmailType::class, [
                'label'              => 'form.email',
                'translation_domain' => 'UserBundle',
            ])
            ->add('currentPassword', PasswordType::class, [
                'label'              => 'form.current_password',
                'translation_domain' => 'UserBundle',
                'mapped'             => false,
                'constraints'        => new UserPassword(['message' => 'user.current_password.invalid']),
            ])
            ->add('ululeUsername', $user->getUluleId() ? HiddenType::class : TextType::class, [
                'label'              => 'form.ulule_username',
                'translation_domain' => 'UserBundle',
                'mapped'             => false,
            ])
            ->add('ululeApiToken', $user->getUluleId() ? HiddenType::class : PasswordType::class, [
                'label'              => 'form.ulule_api_token',
                'translation_domain' => 'UserBundle',
            ])
            ->add('disconnectUlule', $user->getUluleId() ? CheckboxType::class : HiddenType::class, [
                'label'              => 'form.ulule_disconnect',
                'translation_domain' => 'UserBundle',
                'mapped'             => false,
            ])
        ;

        /**
         * Form events
         */
        $builder
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                // Canonicalize properties
                /** @var User $user */
                $user = $event->getForm()->getData();
                $user->setUsernameCanonical($this->canonicalizer->canonicalize($user->getUsername()));
                $user->setEmailCanonical($this->canonicalizer->canonicalize($user->getEmail()));
            })
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                // Manage Ulule Connect
                $form = $event->getForm();

                /** @var User $user */
                $user = $form->getData();

                $disconnectUlule = $form->get('disconnectUlule')->getData();

                if (true === $disconnectUlule) {
                    $user->setUluleApiToken(null);
                    $user->setUluleId(null);

                    return;
                }

                $ululeUsername = $form->get('ululeUsername')->getData();

                if ($ululeUsername) {
                    $tokenField = $form->get('ululeApiToken');
                    $ululeToken = $tokenField->getData() ?: '';

                    if (!$ululeToken) {
                        $error = new FormError($this->translator->trans('form.error.need_api_token', [], 'UserBundle'));
                        $tokenField->addError($error);

                        return;
                    }

                    $ululeUser = $this->ululeClient->basicApiTokenConnect($ululeUsername, $ululeToken);

                    if (!$ululeUser) {
                        $error = new FormError($this->translator->trans('form.error.ulule_credentials_invalid', [], 'UserBundle'));
                        $tokenField->addError($error);

                        return;
                    }

                    $user->setUluleId($ululeUser->getId());
                    $user->setUluleApiToken($ululeToken);
                }
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
