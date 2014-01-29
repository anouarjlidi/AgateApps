<?php

namespace CorahnRin\MapsBundle\Controller;

use CorahnRin\MapsBundle\Entity\Factions;
use CorahnRin\MapsBundle\Form\FactionsType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class FactionsController extends Controller
{
    /**
     * @Route("/admin/maps/factions/")
     * @Template()
     */
    public function adminListAction()
    {
        return array(
            'factions' => $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Factions')->findAll(),
        );
    }

    /**
     * @Route("/admin/maps/factions/add/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addAction()
    {
        $faction = new Factions;
        $form = $this->createForm(new FactionsType, $faction);

        $request = $this->get('request');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($faction);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Faction ajoutée : <strong>'.$faction->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_maps_factions_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'faction' => $faction,
            'title' => 'Ajouter une faction',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_pages_pages_index',),
                'Factions' => array('route'=>'corahnrin_maps_factions_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/factions/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editAction(Factions $faction) {
        $form = $this->createForm(new FactionsType, $faction);

        $request = $this->get('request');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($faction);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Faction modifiée : <strong>'.$faction->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_maps_factions_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'faction' => $faction,
            'title' => 'Modifier une faction',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_pages_pages_index',),
                'Factions' => array('route'=>'corahnrin_maps_factions_adminlist'),
            ),
        );
    }

}
