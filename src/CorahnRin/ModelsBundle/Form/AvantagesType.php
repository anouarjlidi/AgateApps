<?php

namespace CorahnRin\ModelsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AvantagesType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('nameFemale', 'text', array('label' => 'Nom féminin'))
            ->add('description', 'textarea', array('label' => 'Description', 'required' => false))
            ->add('xp', 'integer', array('label' => 'Coût/gain d\'expérience'))
            ->add('augmentation', 'choice', array(
                'label' => 'Possibilités d\'amélioration',
                'choices' => range(0, 3),
            ))
            ->add('bonusdisc', 'choice', array(
                'label' => 'Bonus (+1)',
                'choices' => array(),
                'multiple' => true,
                'required' => false,
                'attr' => array('size' => 10)
            ))
            ->add('isDesv', null, array('label' => 'Désavantage', 'required' => false))
            ->add('isCombatArt', null, array('label' => 'Art de combat', 'required' => false))
            ->add('book', null, array('label' => 'Livre', 'property' => 'name'))
            ->add('save', 'submit', array('label' => 'Enregistrer'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\ModelsBundle\Entity\Avantages'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'corahnrin_charactersbundle_avantages';
    }
}
