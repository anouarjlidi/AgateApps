<?php

namespace CorahnRin\ModelsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SocialClassesType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('description', 'textarea', array('label' => 'Description', 'required'=>false))
            ->add('domains', 'entity', array(
                'class' => 'CorahnRin\ModelsBundle\Entity\Domains',
                'label'=>'Domaines',
                'multiple' => true,
                'required'=>true,
                'attr'=>array('size'=>16),
                'property'=>'name'
            ))
            ->add('save','submit',array('label'=>'Enregistrer'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\ModelsBundle\Entity\SocialClasses'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corahnrin_charactersbundle_socialclass';
    }
}
