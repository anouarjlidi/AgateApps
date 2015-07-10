<?php

namespace AdminBundle\Controller;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @Security("has_role('ROLE_MANAGER')")
 */
class AdminController extends BaseAdminController
{

    /**
     * @Route("/", name="admin")
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }

    /**
     * @param object    $entity
     * @param array     $entityProperties
     * @param string    $view
     *
     * @return \Symfony\Component\Form\Form|void
     */
    public function createEntityForm($entity, array $entityProperties, $view)
    {
        $formCssClass = array_reduce($this->config['design']['form_theme'], function ($previousClass, $formTheme) {
            return sprintf('theme_%s %s', strtolower(str_replace('.html.twig', '', basename($formTheme))), $previousClass);
        });

        $formBuilder = $this->createFormBuilder($entity, array(
            'data_class' => $this->entity['class'],
            'attr' => array('class' => $formCssClass, 'id' => $view.'-form'),
        ));

        foreach ($entityProperties as $name => $metadata) {
            $formFieldOptions = array();

            if ('association' === $metadata['fieldType'] && in_array($metadata['associationType'], array(ClassMetadataInfo::ONE_TO_MANY, ClassMetadataInfo::MANY_TO_MANY))) {
                continue;
            }

            if ('collection' === $metadata['fieldType']) {
                $formFieldOptions = array('allow_add' => true, 'allow_delete' => true);

                if (version_compare(Kernel::VERSION, '2.5.0', '>=')) {
                    $formFieldOptions['delete_empty'] = true;
                }
            }

            $formFieldOptions['attr']['field_type'] = $metadata['fieldType'];
            $formFieldOptions['attr']['field_css_class'] = $metadata['class'];
            $formFieldOptions['attr']['field_help'] = $metadata['help'];

            //------------------------------------------------------------------
            //------------------------------------------------------------------
            // Overrides

            if ($this->entity['name'] === 'Pages' && $name === 'host') {
                $formFieldOptions['choices'] = array_combine($entityProperties['host']['choices'], $entityProperties['host']['choices']);
            }

            // End overrides
            //------------------------------------------------------------------
            //------------------------------------------------------------------

            $formBuilder->add($name, $metadata['fieldType'], $formFieldOptions);
        }

        return $formBuilder->getForm();
    }

}
