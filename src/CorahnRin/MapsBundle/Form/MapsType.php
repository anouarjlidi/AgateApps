<?php

namespace CorahnRin\MapsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MapsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
			->add('image',			array('required'=>false))
            ->add('description',	array('required'=>false))
            ->add('minZoom')
            ->add('maxZoom')
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
