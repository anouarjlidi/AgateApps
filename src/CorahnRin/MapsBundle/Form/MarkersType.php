<?php

namespace CorahnRin\MapsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MarkersType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label'=>'Nom'))
            ->add('coordinates', 'text', array('empty_data'=>'-','label'=>'Coordonnées','required'=>false   ))
            ->add('faction', 'entity', array(
                'class' => 'CorahnRin\MapsBundle\Entity\Factions',
                'empty_value' => '-- Choisissez une faction --',
                'required'=>false,
            ))
            ->add('map', 'entity', array(
                'class' => 'CorahnRin\MapsBundle\Entity\Maps',
                'empty_value' => '-- Choisissez une carte --',
                'label' => 'Carte',
            ))
            ->add('markerType', 'entity', array(
                'class' => 'CorahnRin\MapsBundle\Entity\MarkersTypes',
                'empty_value' => '-- Choisissez un type --',
                'label' => 'Type',
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
            'data_class' => 'CorahnRin\MapsBundle\Entity\Markers'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corahnrin_mapsbundle_markers';
    }
}
