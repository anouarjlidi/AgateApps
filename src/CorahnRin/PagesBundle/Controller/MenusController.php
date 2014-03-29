<?php

namespace CorahnRin\PagesBundle\Controller;

use CorahnRin\PagesBundle\Entity\Menus;
use CorahnRin\PagesBundle\Form\MenusType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MenusController extends Controller {

    /**
     * @Route("/admin/manage_site/menus/")
     * @Template()
     */
    public function adminListAction() {
        return array(
            'menus' => $this->getDoctrine()->getManager()->getRepository('CorahnRinPagesBundle:Menus')->findForAdmin(),
        );
    }

    /**
     * @Route("/admin/manage_site/menus/add/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addAction() {
        return $this->handle_request(new Menus);
    }

    /**
     * @Route("/admin/manage_site/menus/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editAction(Menus $menu) {
        return $this->handle_request($menu);
    }

    /**
     * @Route("/admin/manage_site/menus/delete/{id}")
     * @Template()
     */
    public function deleteAction(Menus $menu)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $menu->setDeleted(1);
        $em->persist($menu);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Le lien de menu <strong>'.$menu->getName().'</strong> a été correctement supprimé.');

        return $this->redirect($this->generateUrl('corahnrin_pages_menus_adminlist'));
    }


	/**
	 * @Template()
	 */
	public function menuAction($route = '') {
        if (preg_match('#^esteren_maps#isUu', $route)) {
            $method_name = 'EsterenMaps';
            $brandTitle = 'Esteren Maps';
            $brandRoute = 'esterenmaps_maps_maps_index';
        } else {
            $method_name = 'CorahnRin';
            $brandTitle = 'Corahn-Rin';
            $brandRoute = 'corahnrin_pages_pages_index';
        }
        $links = $this->{'menu'.$method_name}();
        $langs = $this->get('translator')->getLangs();
		$username = $this->get('fos_user.user_provider.username');
		return array(
            'links' => $links,
            'brandTitle' => $brandTitle,
            'brandRoute' => $brandRoute,
            'route_name' => $route,
            'locale'=>$this->get('session')->get('_locale'),
            'langs' => $langs
        );
	}

    protected function menuCorahnRin(){
		return array(
			'corahnrin_generator_generator_index' => 'Générateur',
			'corahnrin_characters_viewer_list' => 'Personnages',
			'esterenmaps_maps_maps_index' => 'Esteren Maps',
		);
    }

    protected function menuEsterenMaps(){
        $maps = $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Maps')->findAll(true);
        $maps_list = array();
        foreach ($maps as $id => $map) {
            $maps_list[$id] = array(
                'route' => 'esterenmaps_maps_maps_view',
                'name' => $map->getName(),
                'attributes' => array(
                    'id' => $map->getId(),
                    'nameSlug' => $map->getNameSlug(),
                ),
            );
        }
		$links = array(
			'dropdown_list_1' => array(
                'name' => 'Voir une carte',
                'list' => $maps_list,
            ),
			'corahnrin_pages_pages_index' => 'Corahn-Rin',
		);
        return $links;
    }

    private function handle_request($element) {
        $method = preg_replace('#^'.str_replace('\\','\\\\',__CLASS__).'::([a-zA-Z]+)Action$#isUu', '$1', $this->getRequest()->get('_controller'));

        if (null === $element->getPosition()){
            $element->setPosition(0);
        }

        $form = $this->createForm(new MenusType, $element, array('roles' => $this->container->getParameter('security.role_hierarchy.roles')));

        $request = $this->get('request');

        $routes = array();
        foreach ($this->container->get('router')->getRouteCollection()->all() as $name => $route) {
            if (strpos($name, '_') !== 0 && !$route->compile()->getVariables() && !preg_match('#_(add|edit)[^_]*$#isUu', $name) && (!in_array('POST', $route->getMethods()) || (in_array('POST', $route->getMethods()) && in_array('GET', $route->getMethods())) )) {
                $category = 'Autres';
                if (strpos($name, 'corahnrin_characters_') === 0) { $category = 'Générateur de personnages'; }
                if (strpos($name, 'esterenmaps_maps_') === 0) { $category = 'Esteren Maps'; }
                if (strpos($name, 'corahnrin_pages_') === 0) { $category = 'Pages'; }
                if (strpos($name, 'corahnrin_admin_') === 0) { $category = 'Panneau d\'administration'; }
                if (strpos($name, 'pierstoval_translation') === 0) { $category = 'Traduction'; }
                if (strpos($name, 'fos_user_') === 0) { $category = 'Utilisateurs'; }
                $routes[$category][$name] = $name;
                ksort($routes[$category]);
            }
        }
        ksort($routes);
        if ($routes) {
            $form->add('route', 'choice', array(
                'choices' => $routes,
                'required'=>false,
                'empty_value' => '-- Choisissez une route --',
                'label' => 'Route',
            ));
        }

        $request = $this->get('request');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Menu '.($method=='add'?'ajouté':'modifié').' : <strong>'.$element->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_pages_menus_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method=='add'?'Ajouter':'Modifier').' un menu',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Menus' => array('route'=>'corahnrin_pages_menus_adminlist'),
            ),
        );
    }
}
