<?php

namespace CorahnRin\ModelsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SetbacksType extends AbstractType
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
            ->add('malus', null, array('label'=> 'Malus'))
            ->add('save','submit',array('label'=>'Enregistrer'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CorahnRin\ModelsBundle\Entity\Setbacks'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corahnrin_charactersbundle_setbacks';
    }
}
