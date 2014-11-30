<?php

namespace EsterenMaps\AdminBundle\Admin;

use EsterenMaps\MapsBundle\Entity\MarkersTypes;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;

class MarkersTypesAdmin extends Admin {

    /**
     * @var UploadableManager
     */
    private $uploadableManager;

    public function __construct($code, $class, $baseControllerName, UploadableManager $uploadableManager) {
        $this->uploadableManager = $uploadableManager;
        parent::__construct($code, $class, $baseControllerName);
    }

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
            ->add('name', 'text', array('required'=>true))
            ->add('description', 'textarea', array('required'=>false))
            ->add('icon', 'sonata_media_type', array(
                'provider' => 'sonata.media.provider.image',
                'context'  => 'esteren_maps_markers_types',
            ))
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
            ->add('icon')
            ->add('iconName', 'text', array('template' => 'ApplicationSonataAdminBundle:Templates:sonata_field_viewImage.html.twig'))
        ;

    }

}
