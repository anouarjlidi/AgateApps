<?php

namespace CorahnRin\CorahnRinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WeaponsType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $desc = 'Portée à distance, en mètres (laisser vide si l\'arme ne peut être utilisée à distance)';
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Description', 'required' => false))
            ->add('damage', 'integer', array('label' => 'Dégâts'))
            ->add('price', 'integer', array(
                'label' => 'Prix',
                'attr' => array(
                    'placeholder' => 'Prix (en daols de Braise)',
                    'data-toggle' => 'tooltip',
                    'title' => 'Prix (en daols de Braise)',
                    'data-placement' => 'left'
                )
            ))
            ->add('availability', 'choice', array(
                'label' => 'Rareté',
                'choices' => array(
                    'CO' => 'Courant',
                    'FR' => 'Fréquent',
                    'RA' => 'Rare',
                    'EX' => 'Exceptionnel',
                ),
            ))
            ->add('melee', null, array('label' => 'Arme de mêlée', 'required' => false))
            ->add('range', null, array(
                'label' => 'Portée',
                'required' => false,
                'attr' => array(
                    'placeholder' => $desc,
                    'title' => $desc,
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'left'
                )
            ))
            ->add('save', 'submit', array('label' => 'Enregistrer'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\CorahnRinBundle\Entity\Weapons'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'corahnrin_charactersbundle_weapons';
    }
}
