<?php

namespace CorahnRin\CharactersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TraitsType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('nameFemale', 'text', array('label' => 'Nom féminin'))
            ->add('isQuality', 'choice', array(
                'label'=>'Type de trait',
                'choices' => array('Défaut','Qualité'),
                'expanded' => true,
            ))
            ->add('way', null, array('label'=>'Voie', 'property'=>'name', 'required'=>true))
            ->add('isMajor', 'choice', array(
                'label'=>'Score de voie',
                'choices' => array('Mineur (1 ou 2)','Majeur (4 ou 5)'),
                'expanded' => true,
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
            'data_class' => 'CorahnRin\CharactersBundle\Entity\Traits'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corahnrin_charactersbundle_traits';
    }
}
