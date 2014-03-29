<?php

namespace EsterenMaps\MapsBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use EsterenMaps\MapsBundle\Form\RoutesType;
use EsterenMaps\MapsBundle\Form\RoutesTypesType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RoutesController extends Controller {

    /**
     * @Route("/admin/maps/routes/")
     * @Template()
     */
    public function adminListAction() {
        return array(
            'routes' => $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Routes')->findAll(),
            'routesTypes' => $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:RoutesTypes')->findAll()
        );
    }

    /**
     * @Route("/admin/maps/routes/add/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addAction() {
        $route = new Routes;
        $form = $this->createForm(new RoutesType, $route);

        $request = $this->get('request');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($route);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Route ajoutée : <strong>'.$route->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_routes_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'route' => $route,
            'title' => 'Ajouter une route',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Routes' => array('route'=>'esterenmaps_maps_routes_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/routes/types/add")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addTypeAction() {
        $routeType = new \EsterenMaps\MapsBundle\Entity\RoutesTypes;
        $form = $this->createForm(new RoutesTypesType, $routeType);

        $request = $this->get('request');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($routeType);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Type de route ajouté : <strong>'.$routeType->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_routes_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => 'Ajouter un type de route',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Routes' => array('route'=>'esterenmaps_maps_routes_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/routes/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editAction(Routes $route) {

        $form = $this->createForm(new RoutesType, $route);

        $request = $this->get('request');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($route);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Route modifié : <strong>'.$route->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_routes_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'route' => $route,
            'title' => 'Modifier une route',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Routes' => array('route'=>'esterenmaps_maps_routes_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/routes/types/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editTypeAction(RoutesTypes $routeType) {

        $form = $this->createForm(new RoutesTypesType, $routeType);

        $request = $this->get('request');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($routeType);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Type de route modifié : <strong>'.$routeType->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_routes_adminlist'));
        }

        return array(
            'form' => $form->createView(),
//            'route' => $routeType,
            'title' => 'Modifier un type de route',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Routes' => array('route'=>'esterenmaps_maps_routes_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/routes/delete/{id}")
     * @Template()
     */
    public function deleteAction(Routes $route)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $route->setDeleted(1);
        $em->persist($route);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Le route <strong>'.$route->getName().'</strong> a été correctement supprimé.');

        return $this->redirect($this->generateUrl('esterenmaps_maps_routes_adminlist'));
    }

    /**
     * @Route("/admin/maps/routes/deletetype/{id}")
     * @Template()
     */
    public function deleteTypeAction(RoutesTypes $routeType)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $routeType->setDeleted(1);
        $em->persist($routeType);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Le type de route <strong>'.$routeType->getName().'</strong> a été correctement supprimé.');

        return $this->redirect($this->generateUrl('esterenmaps_maps_routes_adminlist'));
    }


}
