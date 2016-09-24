<?php

namespace Esteren\PortalBundle\Form;

use Esteren\PortalBundle\Model\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr'        => [
                    'pattern' => '.{2,}',
                ],
                'constraints' => [
                    new Constraints\Length(['min' => 2]),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Constraints\Email(),
                ],
            ])
            ->add('subject', TextType::class, [
                'attr'        => [
                    'pattern' => '.{3,}' //minlength
                ],
                'constraints' => [
                    new Constraints\Length(['min' => 3]),
                ],
            ])
            ->add('message', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactMessage::class,
        ]);
    }
}
