<?php

namespace CorahnRin\AdminBundle\Controller;

use CorahnRin\ModelsBundle\Entity\Disciplines;
use CorahnRin\ModelsBundle\Form\DisciplinesType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DisciplinesController extends Controller
{
    /**
     * @Route("/admin/generator/disciplines/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller','',preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:'.$name)->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/disciplines/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }
        return $this->handle_request(new Disciplines, $request);
    }

    /**
     * @Route("/admin/generator/disciplines/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Disciplines $discipline, Request $request)
    {
        return $this->handle_request($discipline, $request);
    }

    /**
     * @Route("/admin/generator/disciplines/delete/{id}")
     * @Template()
     */
    public function deleteAction(Disciplines $element)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Discipline supprimé : <strong>'.$element->getName().'</strong>');
        return $this->redirect($this->generateUrl('corahnrin_admin_disciplines_adminlist'));
    }

    private function handle_request(Disciplines $element, Request $request) {
        $method = preg_replace('#^'.str_replace('\\','\\\\',__CLASS__).'::([a-zA-Z]+)Action$#isUu', '$1', $this->getRequest()->get('_controller'));

        $form = $this->createForm(new \CorahnRin\ModelsBundle\Form\DisciplinesType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Discipline '.($method=='add'?'ajouté':'modifié').' : <strong>'.$element->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_disciplines_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method=='add'?'Ajouter':'Modifier').' un Discipline',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Disciplines' => array('route'=>'corahnrin_admin_disciplines_adminlist'),
            ),
        );
    }
}