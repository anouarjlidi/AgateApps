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
    public function addAction()
    {
        $menu = new Menus;
        $form = $this->createForm(new MenusType, $menu, array('roles' => $this->container->getParameter('security.role_hierarchy.roles')));

        $request = $this->get('request');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Menu ajouté : <strong>'.$menu->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_pages_menus_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => 'Ajouter un menu',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Menus' => array('route'=>'corahnrin_pages_menus_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/manage_site/menus/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editAction(Menus $menu) {
        $form = $this->createForm(new MenusType, $menu, array('roles' => $this->container->getParameter('security.role_hierarchy.roles')));

        $request = $this->get('request');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Menu modifié : <strong>'.$menu->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_pages_menus_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => 'Modifier un menu',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Menus' => array('route'=>'corahnrin_pages_menus_adminlist'),
            ),
        );
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
        if (preg_match('#^corahnrin_maps#isUu', $route)) {
            $method_name = 'EsterenMaps';
            $brandTitle = 'Esteren Maps';
            $brandRoute = 'corahnrin_maps_maps_index';
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
			'corahnrin_characters_generator_index' => 'Générateur',
			'corahnrin_characters_viewer_list' => 'Personnages',
			'corahnrin_maps_maps_index' => 'Esteren Maps',
		);
    }

    protected function menuEsterenMaps(){
        $maps = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findAll(true);
        $maps_list = array();
        foreach ($maps as $id => $map) {
            $maps_list[$id] = array(
                'route' => 'corahnrin_maps_maps_view',
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
}
