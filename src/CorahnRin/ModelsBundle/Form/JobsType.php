<?php

namespace CorahnRin\ModelsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobsType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Description', 'required' => false))
            ->add('book', null, array('label' => 'Livre', 'property' => 'name'))
            ->add('domainPrimary', null, array('label' => 'Domaine primaire', 'property' => 'name'))
            ->add('domainsSecondary', null, array(
                'label' => 'Domaines secondaires',
                'attr' => array('size' => 16),
                'property' => 'name'
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\ModelsBundle\Entity\Jobs'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'corahnrin_charactersbundle_jobs';
    }
}
