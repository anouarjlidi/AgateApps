<?php

namespace CorahnRin\ModelsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DisordersType extends AbstractType {
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('name')
            ->add('ways');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\ModelsBundle\Entity\Disorders'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'corahnrin_charactersbundle_disorders';
    }
}
