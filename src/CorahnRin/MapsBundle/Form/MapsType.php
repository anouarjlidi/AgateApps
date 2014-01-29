<?php

namespace CorahnRin\MapsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\DataTransformer\IntegerToLocalizedStringTransformer as Transformer;

class MapsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name', 'text',array('label'=>'Nom'))
        ->add('image',      'file',	array('required'=>false, 'label'=>'Image'))
        ->add('description','textarea',	array('required'=>false,'label'=>'Description'))
        ->add('maxZoom',    'integer',  array('rounding_mode'=>Transformer::ROUND_DOWN,'label'=>'Zoom maximum'))
        ->add('save', 'submit', array('label'=>'Enregistrer'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\MapsBundle\Entity\Maps'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corahnrin_mapsbundle_maps';
    }
}
