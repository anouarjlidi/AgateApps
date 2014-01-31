<?php

namespace CorahnRin\PagesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenusType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label'=>'Ancre du lien'))
            ->add('position', 'number')
            ->add('route', 'text', array('required'=>false))
            ->add('roles', 'choice', array(
                'required' => true,
                'label' => 'Rôles',
                'multiple' => true,
                'attr' => array('size' => '10'),
                'choices' => $this->refactorRoles($options['roles']),
            ))
            ->add('parent', 'entity', array(
                'label'=>'Menu/Lien parent',
                'class'=>'CorahnRin\PagesBundle\Entity\Menus',
                'required' => false,
                'empty_value' => '-- Choisissez un menu parent --',
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
            'data_class' => 'CorahnRin\PagesBundle\Entity\Menus',
            'roles' => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'corahnrin_pagesbundle_menus';
    }

    private function refactorRoles($originRoles) {
        $base_roles = array();
        $super_roles = array();

        foreach ($originRoles as $super_role => $roles_list) {
            $super_roles[$super_role] = $super_role;
            foreach ($roles_list as $base_role) {
                $base_roles[$base_role] = $base_role;
            }
        }

        foreach ($base_roles as $base_role) {
            if (isset($super_roles[$base_role])) {
                unset($base_roles[$base_role]);
            }
        }

        return array(
            'BASE_ROLES' => $base_roles,
            'SUPER_ROLES' => $super_roles,
        );
    }
}
