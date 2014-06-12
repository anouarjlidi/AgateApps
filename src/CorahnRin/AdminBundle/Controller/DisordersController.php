<?php

namespace CorahnRin\AdminBundle\Controller;

use CorahnRin\ModelsBundle\Entity\Disorders;
use CorahnRin\ModelsBundle\Form\DisordersType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DisordersController extends Controller {
    /**
     * @Route("/admin/generator/disorders/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller', '', preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:' . $name)->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/disorders/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }
        return $this->handle_request(new Disorders, $request);
    }

    /**
     * @Route("/admin/generator/disorders/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Disorders $disorder, Request $request) {
        return $this->handle_request($disorder, $request);
    }

    /**
     * @Route("/admin/generator/disorders/delete/{id}")
     */
    public function deleteAction(Disorders $element) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Disorder supprimé : <strong>' . $element->getName() . '</strong>');
        return $this->redirect($this->generateUrl('corahnrin_admin_disorders_adminlist'));
    }

    private function handle_request(Disorders $element, Request $request) {
        $method = preg_replace('#^' . str_replace('\\', '\\\\', __CLASS__) . '::([a-zA-Z]+)Action$#isUu', '$1', $request->get('_controller'));

        $form = $this->createForm(new DisordersType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Désordre mental ' . ($method == 'add' ? 'ajouté'
                    : 'modifié') . ' : <strong>' . $element->getName() . '</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_disorders_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method == 'add' ? 'Ajouter' : 'Modifier') . ' un Désordre mental',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Désordres mentaux' => array('route' => 'corahnrin_admin_disorders_adminlist'),
            ),
        );
    }
}