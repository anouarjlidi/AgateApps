<?php

namespace EsterenMaps\MapsBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Zones;
use EsterenMaps\MapsBundle\Entity\ZonesTypes;
use EsterenMaps\MapsBundle\Form\ZonesType;
use EsterenMaps\MapsBundle\Form\ZonesTypesType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ZonesController extends Controller {

    /**
     * @Route("/admin/maps/zones/")
     * @Template()
     */
    public function adminListAction() {
        $em = $this->getDoctrine()->getManager();
        return array(
            'zones' => $em->getRepository('EsterenMapsBundle:Zones')->findAll(),
            'zonesTypes' => $em->getRepository('EsterenMapsBundle:ZonesTypes')->findForAdmin(),
        );
    }

    /**
     * @Route("/admin/maps/zones/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request) {
        $zone = new Zones;
        $form = $this->createForm(new ZonesType, $zone);

        $form->handleRequest($request);

        if ($form->isValid() && $request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($zone);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Zone ajoutée : <strong>'.$zone->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_zones_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'zone' => $zone,
            'title' => 'Ajouter une zone',
            'breadcrumbs' => array(
                'Accueil' => array('zone' => 'pierstoval_admin_admin_index',),
                'Zones' => array('zone'=>'esterenmaps_maps_zones_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/zones/types/add")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addTypeAction(Request $request) {
        $zoneType = new ZonesTypes;
        $form = $this->createForm(new ZonesTypesType, $zoneType);

        $form->handleRequest($request);

        if ($form->isValid() && $request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($zoneType);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Type de zone ajouté : <strong>'.$zoneType->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_zones_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => 'Ajouter un type de zone',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Zones' => array('route'=>'esterenmaps_maps_zones_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/zones/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Zones $zone, Request $request) {

        $form = $this->createForm(new ZonesType, $zone);

        $form->handleRequest($request);

        if ($form->isValid() && $request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($zone);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Zone modifiée : <strong>'.$zone->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_zones_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'zone' => $zone,
            'title' => 'Modifier une zone',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Zones' => array('route'=>'esterenmaps_maps_zones_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/zones/types/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editTypeAction(ZonesTypes $zoneType, Request $request) {

        $form = $this->createForm(new ZonesTypesType, $zoneType);

        $form->handleRequest($request);

        if ($form->isValid() && $request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($zoneType);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Type de zone modifié : <strong>'.$zoneType->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_zones_adminlist'));
        }

        return array(
            'form' => $form->createView(),
//            'zone' => $zoneType,
            'title' => 'Modifier un type de zone',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Zones' => array('route'=>'esterenmaps_maps_zones_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/zones/delete/{id}")
     */
    public function deleteAction(Zones $zone)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($zone);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'La zone <strong>'.$zone->getName().'</strong> a été correctement supprimé.');

        return $this->redirect($this->generateUrl('esterenmaps_maps_zones_adminlist'));
    }

    /**
     * @Route("/admin/maps/zones/deletetype/{id}")
     */
    public function deleteTypeAction(ZonesTypes $zoneType)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($zoneType);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'Le type de zone <strong>'.$zoneType->getName().'</strong> a été correctement supprimé.');

        return $this->redirect($this->generateUrl('esterenmaps_maps_zones_adminlist'));
    }


}
