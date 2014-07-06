<?php

namespace EsterenMaps\MapsBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Factions;
use EsterenMaps\MapsBundle\Form\FactionsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FactionsController extends Controller {

    /**
     * @Route("/admin/maps/factions/")
     * @Template()
     */
    public function adminListAction() {
        return array(
            'factions' => $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Factions')->findAll(),
        );
    }

    /**
     * @Route("/admin/maps/factions/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request) {
        $faction = new Factions;
        $form = $this->createForm(new FactionsType, $faction);

        $form->handleRequest($request);

        if ($form->isValid() && $request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($faction);
            $em->flush();
            $request->getSession()->getFlashBag()
                 ->add('success', 'Faction ajoutée : <strong>'.$faction->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_factions_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'faction' => $faction,
            'title' => 'Ajouter une faction',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Factions' => array('route' => 'esterenmaps_maps_factions_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/factions/delete/{id}")
     */
    public function deleteAction(Factions $zone, Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($zone);
        $em->flush();

        $request->getSession()->getFlashBag()
             ->add('success', 'La faction <strong>'.$zone->getName().'</strong> a été correctement supprimé.');

        return $this->redirect($this->generateUrl('esterenmaps_maps_factions_adminlist'));
    }

    /**
     * @Route("/admin/maps/factions/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Factions $faction, Request $request) {
        $form = $this->createForm(new FactionsType, $faction);

        $form->handleRequest($request);

        if ($form->isValid() && $request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($faction);
            $em->flush();
            $request->getSession()->getFlashBag()
                 ->add('success', 'Faction modifiée : <strong>'.$faction->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_factions_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'faction' => $faction,
            'title' => 'Modifier une faction',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Factions' => array('route' => 'esterenmaps_maps_factions_adminlist'),
            ),
        );
    }

}
