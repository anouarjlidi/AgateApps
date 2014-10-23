<?php

namespace EsterenMaps\MapsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class RoutesTypesAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->add('name', 'text', array('required'=>true))
            ->add('description', 'textarea', array('required'=>false))
            ->add('color', 'text', array('required'=>false, 'attr' => array('class' => 'colorpicker')))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
//        $datagridMapper
//            ->add('name')
//        ;
    }

    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
            ->addIdentifier('name', 'text')
            ->add('description', 'text')
            ->add('color', 'text', array('template' => 'ApplicationSonataAdminBundle:Templates:sonata_field_color.html.twig'))
        ;

    }

}
