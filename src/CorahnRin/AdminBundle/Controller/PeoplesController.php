<?php

namespace CorahnRin\AdminBundle\Controller;

use CorahnRin\ModelsBundle\Entity\Peoples;
use CorahnRin\ModelsBundle\Form\PeoplesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PeoplesController extends Controller {
    /**
     * @Route("/admin/generator/peoples/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller', '', preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinModelsBundle:' . $name)->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/peoples/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }
        return $this->handle_request(new Peoples, $request);
    }

    /**
     * @Route("/admin/generator/peoples/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Peoples $people, Request $request) {
        return $this->handle_request($people, $request);
    }

    /**
     * @Route("/admin/generator/peoples/delete/{id}")
     * @Template()
     */
    public function deleteAction(Peoples $element) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->persist($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Peuple supprimé : <strong>' . $element->getName() . '</strong>');
        return $this->redirect($this->generateUrl('corahnrin_admin_peoples_adminlist'));
    }

    private function handle_request(Peoples $element, Request $request) {
        $method = preg_replace('#^' . str_replace('\\', '\\\\', __CLASS__) . '::([a-zA-Z]+)Action$#isUu', '$1', $request->get('_controller'));

        $form = $this->createForm(new PeoplesType(), $element);

        $form->handleRequest($request);

        if ($form->isValid() && $request->isMethod('POST')) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Peuple ' . ($method == 'add' ? 'ajouté'
                    : 'modifié') . ' : <strong>' . $element->getName() . '</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_peoples_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method == 'add' ? 'Ajouter' : 'Modifier') . ' un peuple',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Peuples' => array('route' => 'corahnrin_admin_peoples_adminlist'),
            ),
        );
    }
}