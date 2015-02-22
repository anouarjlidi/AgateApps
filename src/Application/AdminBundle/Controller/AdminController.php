<?php

namespace Application\AdminBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_MANAGER')")
 */
class AdminController extends BaseAdminController
{

    protected $allowedActions = array('list', 'edit', 'new', 'show', 'search', 'delete', 'interactive');

    /**
     * @Route("/", name="admin")
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }

    public function interactiveAction()
    {
        if ($this->entity['name'] === 'Maps') {
            $map = $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Maps')->findOneBy(array('id' => $this->request->query->get('id')));

            if ($map) {
                $controller = $this->container->get('esteren_maps.controllers.admin');
                $controller->setContainer($this->container);
                return $controller->editAction($map, $this->request);
            }
        }
        return $this->redirect($this->generateUrl('admin'));
    }

    public function listAction()
    {
        if ($this->entity['name'] === 'Maps') {
            if (!in_array('interactive', $this->config['list_actions'])) {
                $this->config['list_actions'][] = 'interactive';
            }
        }
        return parent::listAction();
    }

}
