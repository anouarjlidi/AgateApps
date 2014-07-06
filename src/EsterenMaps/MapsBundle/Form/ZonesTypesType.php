<?php

namespace EsterenMaps\MapsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ZonesTypesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label'=>'Nom'))
            ->add('parent', 'entity', array(
                'class' => 'EsterenMaps\MapsBundle\Entity\ZonesTypes',
                'empty_value' => '-- Choisissez une catégorie parente --',
                'label' => 'Catégorie parente',
                'property' => 'name',
            ))
            ->add('save', 'submit', array('label'=>'Enregistrer'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EsterenMaps\MapsBundle\Entity\ZonesTypes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'esteren_mapsbundle_zonestypes';
    }
}
