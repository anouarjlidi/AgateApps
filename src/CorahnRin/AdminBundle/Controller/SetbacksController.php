<?php

namespace CorahnRin\AdminBundle\Controller;

use CorahnRin\ModelsBundle\Entity\Setbacks;
use CorahnRin\ModelsBundle\Form\SetbacksType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SetbacksController extends Controller
{
    /**
     * @Route("/admin/generator/setbacks/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller','',preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:'.$name)->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/setbacks/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }
        return $this->handle_request(new Setbacks, $request);
    }

    /**
     * @Route("/admin/generator/setbacks/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Setbacks $setback, Request $request)
    {
        return $this->handle_request($setback, $request);
    }

    /**
     * @Route("/admin/generator/setbacks/delete/{id}")
     * @Template()
     */
    public function deleteAction(Setbacks $element)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->persist($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Revers supprimé : <strong>'.$element->getName().'</strong>');
        return $this->redirect($this->generateUrl('corahnrin_admin_setbacks_adminlist'));
    }

    private function handle_request(Setbacks $element, Request $request) {
        $method = preg_replace('#^'.str_replace('\\','\\\\',__CLASS__).'::([a-zA-Z]+)Action$#isUu', '$1', $this->getRequest()->get('_controller'));

        $form = $this->createForm(new \CorahnRin\ModelsBundle\Form\SetbacksType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Revers '.($method=='add'?'ajouté':'modifié').' : <strong>'.$element->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_setbacks_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method=='add'?'Ajouter':'Modifier').' un revers',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Revers' => array('route'=>'corahnrin_admin_setbacks_adminlist'),
            ),
        );
    }
}