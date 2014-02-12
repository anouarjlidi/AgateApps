<?php

namespace CorahnRin\MapsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RoutesTypesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label'=>'Nom'))
            ->add('save', 'submit', array('label'=>'Enregistrer'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\MapsBundle\Entity\RoutesTypes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corahnrin_mapsbundle_routestypes';
    }
}
