<?php

namespace CorahnRin\CorahnRinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArmorsType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Description', 'required' => false))
            ->add('protection', 'integer', array('label' => 'Protection'))
            ->add('price', 'integer', array('label' => 'Prix (en daols de Braise)'))
            ->add('availability', 'choice', array(
                'label' => 'Rareté',
                'choices' => array(
                    'CO' => 'Courant',
                    'FR' => 'Fréquent',
                    'RA' => 'Rare',
                    'EX' => 'Exceptionnel',
                ),
            ))
            ->add('save', 'submit', array('label' => 'Enregistrer'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\CorahnRinBundle\Entity\Armors'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'corahnrin_charactersbundle_armors';
    }
}