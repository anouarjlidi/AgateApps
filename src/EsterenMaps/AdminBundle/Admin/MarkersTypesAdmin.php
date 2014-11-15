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
            ->add('iconName', 'file', array('required' => false, 'data_class' => null, 'mapped' => true))
        ;
    }

    /**
     * @param MarkersTypes $object
     * @return mixed
     */
    public function prePersist($object)
    {
        if ($object->getIconName()){
            $this->uploadableManager->markEntityToUpload($object, $object->getIconName());
        }
    }

    /**
     * @param MarkersTypes $object
     * @return mixed
     */
    public function preUpdate($object)
    {
        if ($object->getIconName()){
            $this->uploadableManager->markEntityToUpload($object, $object->getIconName());
        }
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
            ->add('iconName', 'text', array('template' => 'ApplicationSonataAdminBundle:Templates:sonata_field_viewImage.html.twig'))
        ;

    }

}
