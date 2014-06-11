<?php

namespace CorahnRin\AdminBundle\Controller;

use CorahnRin\ModelsBundle\Entity\SocialClasses;
use CorahnRin\ModelsBundle\Form\SocialClassesType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SocialClassesController extends Controller
{
    /**
     * @Route("/admin/generator/socialclasses/")
     * @Template()
     */
    public function adminListAction()
    {
        return array(
            'socialClasses' => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:SocialClasses')->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/socialclasses/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }
        return $this->handle_request(new SocialClasses, $request);
    }

    /**
     * @Route("/admin/generator/socialclasses/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(SocialClasses $socialClass, Request $request)
    {
        return $this->handle_request($socialClass, $request);
    }

    /**
     * @Route("/admin/generator/socialclasses/delete/{id}")
     */
    public function deleteAction(SocialClasses $element)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->persist($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Classe sociale supprimée : <strong>' . $element->getName() . '</strong>');
        return $this->redirect($this->generateUrl('corahnrin_admin_socialclasses_adminlist'));
    }

    private function handle_request(SocialClasses $element, Request $request)
    {
        $method = preg_replace('#^' . str_replace('\\', '\\\\', __CLASS__) . '::([a-zA-Z]+)Action$#isUu', '$1', $request->get('_controller'));

        $form = $this->createForm(new SocialClassesType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Classe sociale ' . ($method == 'add' ? 'ajoutée' : 'modifiée') . ' : <strong>' . $element->getName() . '</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_socialclasses_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method == 'add' ? 'Ajouter' : 'Modifier') . ' un revers',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Classes Sociales' => array('route' => 'corahnrin_admin_socialclasses_adminlist'),
            ),
        );
    }
}