<?php

namespace EsterenMaps\MapsBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\MarkersTypes;
use EsterenMaps\MapsBundle\Form\MarkersType;
use EsterenMaps\MapsBundle\Form\MarkersTypesType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MarkersController extends Controller {

    /**
     * @Route("/admin/maps/markers/")
     * @Template()
     */
    public function adminListAction() {
        return array(
            'markers' => $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Markers')->findAll(),
            'markersTypes' => $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:MarkersTypes')->findAll()
        );
    }

    /**
     * @Route("/admin/maps/markers/add/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request) {
        $marker = new Markers;
        $form = $this->createForm(new MarkersType, $marker);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($marker);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Marqueur ajouté : <strong>'.$marker->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_markers_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'marker' => $marker,
            'title' => 'Ajouter un marqueur',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Marqueurs' => array('route'=>'esterenmaps_maps_markers_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/markers/types/add")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addTypeAction(Request $request) {
        $markerType = new MarkersTypes;
        $form = $this->createForm(new MarkersTypesType, $markerType);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($markerType);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Type de marqueur ajouté : <strong>'.$markerType->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_markers_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => 'Ajouter un type de marqueur',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Marqueurs' => array('route'=>'esterenmaps_maps_markers_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/markers/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editAction(Markers $marker, Request $request) {

        $form = $this->createForm(new MarkersType, $marker);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($marker);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Marqueur modifié : <strong>'.$marker->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_markers_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'marker' => $marker,
            'title' => 'Modifier un marqueur',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Marqueurs' => array('route'=>'esterenmaps_maps_markers_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/markers/types/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editTypeAction(MarkersTypes $markerType, Request $request) {

        $form = $this->createForm(new MarkersTypesType, $markerType);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($markerType);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Type de marqueur modifié : <strong>'.$markerType->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_markers_adminlist'));
        }

        return array(
            'form' => $form->createView(),
//            'marker' => $markerType,
            'title' => 'Modifier un type de marqueur',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Marqueurs' => array('route'=>'esterenmaps_maps_markers_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/markers/delete/{id}")
     * @Template()
     */
    public function deleteAction(Markers $marker)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $marker->setDeleted(1);
        $em->persist($marker);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Le marqueur <strong>'.$marker->getName().'</strong> a été correctement supprimé.');

        return $this->redirect($this->generateUrl('esterenmaps_maps_markers_adminlist'));
    }

    /**
     * @Route("/admin/maps/markers/deletetype/{id}")
     * @Template()
     */
    public function deleteTypeAction(MarkersTypes $markerType)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $markerType->setDeleted(1);
        $em->persist($markerType);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Le type de marqueur <strong>'.$markerType->getName().'</strong> a été correctement supprimé.');

        return $this->redirect($this->generateUrl('esterenmaps_maps_markers_adminlist'));
    }


}
