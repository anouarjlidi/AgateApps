<?php

namespace EsterenMaps\AdminBundle\Admin;

use EsterenMaps\MapsBundle\Entity\Maps;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;

class MapsAdmin extends Admin {

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
            ->add('name', 'text', array('required'=>true));
        if ($this->id($this->getSubject())) {
            // Slug on edit
            $formMapper->add('nameSlug', 'text', array('required' => !!$this->id($this->getSubject())));
        }
        $formMapper->add('description', 'textarea', array('required'=>false))
            ->add('maxZoom', 'choice', array('required'=>true, 'choices' => array_combine(range(1,10), range(1,10))))
        ;
        if (!$this->id($this->getSubject())) {
            $formMapper->add('image', 'file', array('required' => true, 'data_class' => null, 'mapped' => true));
        } else {
            $formMapper->add('image', 'text', array('required' => true, 'disabled' => true, 'data_class' => null, 'mapped' => true));
        }
    }

    /**
     * @param Maps $object
     * @return mixed
     */
    public function prePersist($object)
    {
        $this->uploadableManager->markEntityToUpload($object, $object->getImage());
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
//            ->add('image', 'text')
            ->add('image', 'text', array('template' => 'ApplicationSonataAdminBundle:Templates:sonata_field_viewImage.html.twig'))
            ->add('maxZoom', 'number')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'interactive' => array(
                        'template' => 'EsterenMapsAdminBundle:AdminMaps:sonata_action_button.html.twig'
                    ),
                    'delete' => array(),
                )
            ))
        ;

    }

}
