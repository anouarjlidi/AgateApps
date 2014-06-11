<?php

namespace CorahnRin\AdminBundle\Controller;

use CorahnRin\ModelsBundle\Entity\Miracles;
use CorahnRin\ModelsBundle\Form\MiraclesType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MiraclesController extends Controller
{
    /**
     * @Route("/admin/generator/miracles/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller','',preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:'.$name)->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/miracles/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }
        return $this->handle_request(new Miracles, $request);
    }

    /**
     * @Route("/admin/generator/miracles/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Miracles $miracle, Request $request)
    {
        return $this->handle_request($miracle, $request);
    }

    /**
     * @Route("/admin/generator/miracles/delete/{id}")
     * @Template()
     */
    public function deleteAction(Miracles $element)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Miracle supprimé : <strong>'.$element->getName().'</strong>');
        return $this->redirect($this->generateUrl('corahnrin_admin_miracles_adminlist'));
    }

    private function handle_request(Miracles $element, Request $request) {
        $method = preg_replace('#^'.str_replace('\\','\\\\',__CLASS__).'::([a-zA-Z]+)Action$#isUu', '$1', $this->getRequest()->get('_controller'));

        $form = $this->createForm(new \CorahnRin\ModelsBundle\Form\MiraclesType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Miracle '.($method=='add'?'ajouté':'modifié').' : <strong>'.$element->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_miracles_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method=='add'?'Ajouter':'Modifier').' un Miracle',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Miracles' => array('route'=>'corahnrin_admin_miracles_adminlist'),
            ),
        );
    }
}