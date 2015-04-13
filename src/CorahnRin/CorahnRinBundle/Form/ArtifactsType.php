<?php

namespace CorahnRin\CorahnRinBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArtifactsType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Description', 'required' => false))
            ->add('price', 'integer', array('label' => 'Prix'))
            ->add('consumption', 'integer', array('label' => 'Consommation (en charges)'))
            ->add('consumptionInterval', 'integer', array('label' => 'Intervalle de consommation (en heures)'))
            ->add('tank', 'integer', array('label' => 'Réservoir (charges)', 'required' => false))
            ->add('resistance', 'integer', array('label' => 'Résistance'))
            ->add('vulnerability', 'text', array('label' => 'Vulnérabilités', 'required' => false))
            ->add('handling', 'text', array('label' => 'Ergonomie', 'required' => false))
            ->add('damage', 'number', array('label' => 'Dégâts infligés', 'required' => false))
            ->add('flux', null, array('label' => 'Type de Flux', 'property' => 'name'))
            ->add('save', 'submit', array('label' => 'Enregistrer'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\CorahnRinBundle\Entity\Artifacts'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'corahnrin_charactersbundle_artifacts';
    }
}
