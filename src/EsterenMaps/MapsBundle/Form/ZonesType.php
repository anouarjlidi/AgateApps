<?php

namespace EsterenMaps\MapsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ZonesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label'=>'Nom'))
            ->add('coordinates', 'textarea', array('empty_data'=>'-','label'=>'Coordonnées','required'=>false,'disabled'=>true))
            ->add('faction', 'entity', array(
                'class' => 'EsterenMaps\MapsBundle\Entity\Factions',
                'empty_value' => '-- Choisissez une faction --',
                'required'=>false,
                'property' => 'name',
            ))
            ->add('map', 'entity', array(
                'class' => 'EsterenMaps\MapsBundle\Entity\Maps',
                'empty_value' => '-- Choisissez une carte --',
                'label' => 'Carte',
                'property' => 'name',
            ))
            ->add('zoneType', 'entity', array(
                'class' => 'EsterenMaps\MapsBundle\Entity\ZonesTypes',
                'empty_value' => '-- Choisissez un type de zone --',
                'label' => 'Type de zone',
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
            'data_class' => 'EsterenMaps\MapsBundle\Entity\Zones'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'esteren_mapsbundle_zones';
    }
}
