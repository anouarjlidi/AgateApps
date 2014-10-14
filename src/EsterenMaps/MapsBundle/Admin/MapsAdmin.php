<?php

namespace EsterenMaps\MapsBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;

class MapsAdmin extends Admin {


    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->add('name', 'text', array('required'=>true))
            ->add('nameSlug', 'text', array('required' => !!$this->id($this->getSubject())))
            ->add('image', 'text', array('required'=>true))//TODO : Transformer ce champ en un champ "File"
            ->add('description', 'textarea', array('required'=>false))
            ->add('maxZoom', 'choice', array('required'=>true, 'choices' => array_combine(range(1,10), range(1,10))))
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
            ->add('nameSlug', 'text')
            ->add('image', 'text')
            ->add('maxZoom', 'number')
        ;
    }

}
