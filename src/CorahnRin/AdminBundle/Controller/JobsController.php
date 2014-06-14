<?php

namespace CorahnRin\AdminBundle\Controller;

use CorahnRin\ModelsBundle\Entity\Jobs;
use CorahnRin\ModelsBundle\Form\JobsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class JobsController extends Controller {
    /**
     * @Route("/admin/generator/jobs/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller', '', preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinModelsBundle:' . $name)->findAllPerBook(),
        );
    }

    /**
     * @Route("/admin/generator/jobs/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }
        return $this->handle_request(new Jobs, $request);
    }

    /**
     * @Route("/admin/generator/jobs/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Jobs $job, Request $request) {
        return $this->handle_request($job, $request);
    }

    /**
     * @Route("/admin/generator/jobs/delete/{id}")
     */
    public function deleteAction(Jobs $element) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Métier supprimé : <strong>' . $element->getName() . '</strong>');
        return $this->redirect($this->generateUrl('corahnrin_admin_jobs_adminlist'));
    }

    private function handle_request(Jobs $element, Request $request) {
        $method = preg_replace('#^' . str_replace('\\', '\\\\', __CLASS__) . '::([a-zA-Z]+)Action$#isUu', '$1', $request->get('_controller'));

        $form = $this->createForm(new JobsType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Métier ' . ($method == 'add' ? 'ajouté'
                    : 'modifié') . ' : <strong>' . $element->getName() . '</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_jobs_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method == 'add' ? 'Ajouter' : 'Modifier') . ' un métier',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Métiers' => array('route' => 'corahnrin_admin_jobs_adminlist'),
            ),
        );
    }
}