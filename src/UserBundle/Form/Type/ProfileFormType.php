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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use UserBundle\Util\Canonicalizer;
use UserBundle\Entity\User;

class ProfileFormType extends AbstractType
{
    private $canonicalizer;

    public function __construct(Canonicalizer $canonicalizer)
    {
        $this->canonicalizer = $canonicalizer;
        $this->ululeClient   = $ululeClient;
        $this->translator    = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
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
        ;

        /*
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
