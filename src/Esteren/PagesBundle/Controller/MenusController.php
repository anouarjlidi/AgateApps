<?php

namespace Esteren\PagesBundle\Controller;

use Esteren\PagesBundle\Entity\Menus;
use Esteren\PagesBundle\Form\MenusType;
use Esteren\PagesBundle\Repository\MenusRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MenusController extends Controller {

    /**
     * @Route("/admin/manage_site/menus/")
     * @Template()
     */
    public function adminListAction() {

        /** @var MenusRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository('EsterenPagesBundle:Menus');

        $list = $repo->findForAdmin();

        foreach ($list as $element) {
            if ($element->getParent()){
                $element->getParent()->addChild($element);
            }
        }

        return array(
            'menus' => $list,
        );
    }

    /**
     * @Route("/admin/manage_site/menus/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request) {
        return $this->handle_request(new Menus, $request);
    }

    /**
     * @Route("/admin/manage_site/menus/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Menus $menu, Request $request) {
        return $this->handle_request($menu, $request);
    }

    /**
     * @Route("/admin/manage_site/menus/delete/{id}")
     */
    public function deleteAction(Menus $menu) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MANAGE_SITE_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($menu);
        $em->flush();

        $this->container->get('session')->getFlashBag()
             ->add('success', 'Le lien de menu <strong>'.$menu->getName().'</strong> a été correctement supprimé.');

        return $this->redirect($this->generateUrl('esteren_pages_menus_adminlist'));
    }

    /**
     * @Template()
     */
    public function menuAction($route = '', $route_params = array()) {
        if (preg_match('#^esteren_maps#isUu', $route)) {
            $method_name = 'EsterenMaps';
            $brandTitle = 'Esteren Maps';
            $brandRoute = 'esterenmaps_maps_maps_index';
        } else {
            $method_name = 'CorahnRin';
            $brandTitle = 'Corahn-Rin';
            $brandRoute = 'esteren_pages_pages_index';
        }
        $links = $this->{'menu'.$method_name}();
        $langs = $this->container->get('translator')->getLangs();
        return array(
            'links' => $links,
            'brandTitle' => $brandTitle,
            'brandRoute' => $brandRoute,
            'route_name' => $route,
            'locale' => $this->get('session')->get('_locale'),
            'langs' => $langs,
            'route_params' => $route_params ?: array(),
        );
    }

    protected function menuCorahnRin() {
        return array(
            'corahnrin_generator_generator_index' => 'Générateur',
            'corahnrin_characters_viewer_list' => 'Personnages',
            'esterenmaps_maps_maps_index' => 'Esteren Maps',
        );
    }

    protected function menuEsterenMaps() {
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
            'esteren_pages_pages_index' => 'Corahn-Rin',
        );
        return $links;
    }

    /**
     * @param Menus $element
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function handle_request($element, Request $request) {
        $method = preg_replace('#^'.str_replace('\\', '\\\\', __CLASS__).'::([a-zA-Z]+)Action$#isUu', '$1', $request->get('_controller'));

        if (null === $element->getPosition()) {
            $element->setPosition(0);
        }

        $form = $this->createForm(new MenusType, $element, array('roles' => $this->container->getParameter('security.role_hierarchy.roles')));

        $routes = array();
        foreach ($this->container->get('router')->getRouteCollection()->all() as $name => $route) {
            if (
                strpos($name, '_') !== 0
                && !$route->compile()->getVariables()
                && !preg_match('#_(add|edit)[^_]*$#isUu', $name)
                && (
                    !in_array('POST', $route->getMethods())
                    || (
                        in_array('POST', $route->getMethods())
                        && in_array('GET', $route->getMethods())
                    )
                )
            ) {
                $category = 'Autres';
                if (strpos($name, 'corahnrin_characters_') === 0) {
                    $category = 'Générateur de personnages';
                }
                if (strpos($name, 'corahnrin_admin_') === 0) {
                    $category = 'Administration de Corahn-Rin';
                }
                if (strpos($name, 'esterenmaps_') === 0) {
                    $category = 'Esteren Maps';
                }
                if (strpos($name, 'esteren_pages_') === 0) {
                    $category = 'Pages';
                }
                if (strpos($name, 'pierstoval_admin_') === 0) {
                    $category = 'Panneau d\'administration';
                }
                if (strpos($name, 'pierstoval_translation') === 0) {
                    $category = 'Traduction';
                }
                if (strpos($name, 'fos_user_') === 0) {
                    $category = 'Utilisateurs';
                }
                $routes[$category][$name] = $name;
                ksort($routes[$category]);
            }
        }
        ksort($routes);
        if ($routes) {
            $form->add('route', 'choice', array(
                'choices' => $routes,
                'required' => false,
                'empty_value' => '-- Choisissez une route --',
                'label' => 'Route',
            ));
        }

        $form->handleRequest($request);

        if ($form->isValid() && $request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $request->getSession()->getFlashBag()->add('success',
                'Menu '.($method == 'add' ? 'ajouté' : 'modifié').' : <strong>'.$element->getName().'</strong>'
            );
            return $this->redirect($this->generateUrl('esteren_pages_menus_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method == 'add' ? 'Ajouter' : 'Modifier').' un menu',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Menus' => array('route' => 'esteren_pages_menus_adminlist'),
            ),
        );
    }
}
