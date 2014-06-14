<?php

namespace CorahnRin\AdminBundle\Controller;

use CorahnRin\ModelsBundle\Entity\Traits;
use CorahnRin\ModelsBundle\Form\TraitsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TraitsController extends Controller {
    /**
     * @Route("/admin/generator/traits/")
     * @Template()
     */
    public function adminListAction() {
        return $this->getDoctrine()->getManager()->getRepository('CorahnRinModelsBundle:Traits')->findAllDifferenciated();
    }

    /**
     * @Route("/admin/generator/traits/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }
        return $this->handle_request(new Traits, $request);
    }

    /**
     * @Route("/admin/generator/traits/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Traits $trait, Request $request) {
        return $this->handle_request($trait, $request);
    }

    /**
     * @Route("/admin/generator/traits/delete/{id}")
     */
    public function deleteAction(Traits $element) {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->persist($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Trait de caractère supprimé : <strong>' . $element->getName() . '</strong>');
        return $this->redirect($this->generateUrl('corahnrin_admin_traits_adminlist'));
    }

    private function handle_request(Traits $element, Request $request) {
        $method = preg_replace('#^' . str_replace('\\', '\\\\', __CLASS__) . '::([a-zA-Z]+)Action$#isUu', '$1', $request->get('_controller'));

        $form = $this->createForm(new TraitsType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Trait de caractère ' . ($method == 'add' ? 'ajouté'
                    : 'modifié') . ' : <strong>' . $element->getName() . '</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_traits_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method == 'add' ? 'Ajouter' : 'Modifier') . ' un trait',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Traits de caractère' => array('route' => 'corahnrin_admin_traits_adminlist'),
            ),
        );
    }
}