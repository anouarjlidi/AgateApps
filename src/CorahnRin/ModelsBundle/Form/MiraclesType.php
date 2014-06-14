<?php

namespace CorahnRin\ModelsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MiraclesType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Description', 'required' => false))
            ->add('isMajor', 'choice', array(
                'label' => 'Type',
                'choices' => array(
                    0 => 'Miracle mineur',
                    1 => 'Miracle majeur',
                ),
                'expanded' => true,
            ))
            ->add('book', null, array('label' => 'Livre', 'property' => 'name'))
            ->add('save', 'submit', array('label' => 'Enregistrer'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\ModelsBundle\Entity\Miracles'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'corahnrin_charactersbundle_miracles';
    }
}
