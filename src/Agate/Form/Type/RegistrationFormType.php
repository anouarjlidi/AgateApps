<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Agate\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Agate\Entity\User;
use Agate\Util\Canonicalizer;

class RegistrationFormType extends AbstractType
{
    private $canonicalizer;

    public function __construct(Canonicalizer $canonicalizer)
    {
        $this->canonicalizer = $canonicalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $canonicalizer = $this->canonicalizer;

        $builder
            ->add('email', EmailType::class, [
                'label'              => 'form.email',
                'translation_domain' => 'user',
            ])
            ->add('emailCanonical', HiddenType::class)
            ->add('username', null, [
                'label'              => 'form.username',
                'translation_domain' => 'user',
            ])
            ->add('usernameCanonical', HiddenType::class)
            ->add('plainPassword', PasswordType::class, [
                'translation_domain' => 'user',
                'label'              => 'form.password',
                'invalid_message'    => 'user.password.mismatch',
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) use ($canonicalizer) {
                /** @var User $user */
                $user = $event->getForm()->getData();
                $user->setUsernameCanonical($canonicalizer->canonicalize($user->getUsername()));
                $user->setEmailCanonical($canonicalizer->canonicalize($user->getEmail()));
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
