<?php

namespace CorahnRin\CharactersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DisciplinesType extends AbstractType
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
            ->add('book', null, array('label'=>'Livre'))
            ->add('domains', 'entity', array(
                'class' => 'CorahnRin\CharactersBundle\Entity\Domains',
                'label'=>'Domaines',
                'multiple' => true,
                'required'=>true,
                'attr'=>array('size'=>16),
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
            'data_class' => 'CorahnRin\CharactersBundle\Entity\Disciplines'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corahnrin_charactersbundle_disciplines';
    }
}
