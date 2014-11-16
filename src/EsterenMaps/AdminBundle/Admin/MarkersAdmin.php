<?php

namespace EsterenMaps\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MarkersAdmin extends Admin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->add('name', 'text', array('required'=>true))
            ->add('description', 'textarea', array('required'=>false))
            ->add('altitude', 'number', array('required'=>false))
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
            ->add('latitude', 'text')
            ->add('longitude', 'text')
            ->add('map', 'many_to_one', array('associated_property' => 'name',))
            ->add('faction', 'many_to_one', array('associated_property' => 'name',))
            ->add('markerType', 'many_to_one', array('associated_property' => 'name',))
        ;

    }

}
