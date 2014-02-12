<?php

namespace CorahnRin\MapsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RoutesType extends AbstractType
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
            ->add('markerStart', 'entity', array(
                'class' => 'CorahnRin\MapsBundle\Entity\Markers',
                'empty_value' => '-- Choisissez un marqueur de "début" --',
                'label' => 'Marqueur de "début"',
                'required'=>true,
            ))
            ->add('markerEnd', 'entity', array(
                'class' => 'CorahnRin\MapsBundle\Entity\Markers',
                'empty_value' => '-- Choisissez un marqueur de "fin" --',
                'label' => 'Marqueur de "fin"',
                'required'=>true,
            ))
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
            ->add('routeType', 'entity', array(
                'class' => 'CorahnRin\MapsBundle\Entity\RoutesTypes',
                'empty_value' => '-- Choisissez un type de route --',
                'label' => 'Type de route',
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
            'data_class' => 'CorahnRin\MapsBundle\Entity\Routes'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corahnrin_mapsbundle_routes';
    }
}
