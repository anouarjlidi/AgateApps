<?php

namespace CorahnRin\CharactersBundle\Controller;

use CorahnRin\CharactersBundle\Entity\Jobs;
use CorahnRin\CharactersBundle\Form\JobsType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class JobsController extends Controller
{
    /**
     * @Route("/admin/generator/jobs/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller','',preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:'.$name)->findAllPerBook(),
        );
    }

    /**
     * @Route("/admin/generator/jobs/add/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }
        return $this->handle_request(new Jobs, $request);
    }

    /**
     * @Route("/admin/generator/jobs/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editAction(Jobs $job, Request $request)
    {
        return $this->handle_request($job, $request);
    }

    /**
     * @Route("/admin/generator/jobs/delete/{id}")
     * @Template()
     */
    public function deleteAction(Jobs $element)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Métier supprimé : <strong>'.$element->getName().'</strong>');
        return $this->redirect($this->generateUrl('corahnrin_characters_jobs_adminlist'));
    }

    private function handle_request(Jobs $element, Request $request) {
        $method = preg_replace('#^'.str_replace('\\','\\\\',__CLASS__).'::([a-zA-Z]+)Action$#isUu', '$1', $this->getRequest()->get('_controller'));

        $form = $this->createForm(new \CorahnRin\CharactersBundle\Form\JobsType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Métier '.($method=='add'?'ajouté':'modifié').' : <strong>'.$element->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_characters_jobs_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method=='add'?'Ajouter':'Modifier').' un métier',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Métiers' => array('route'=>'corahnrin_characters_jobs_adminlist'),
            ),
        );
    }
}