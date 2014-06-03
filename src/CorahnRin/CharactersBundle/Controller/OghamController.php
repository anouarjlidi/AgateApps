<?php

namespace CorahnRin\CharactersBundle\Controller;

use CorahnRin\CharactersBundle\Entity\Ogham;
use CorahnRin\CharactersBundle\Entity\OghamTypes;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OghamController extends Controller
{
    /**
     * @Route("/admin/generator/ogham/")
     * @Template()
     */
    public function adminListAction() {
        return array(
            'ogham_list' => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:Ogham')->findAll(),
            'oghamTypes' => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:OghamTypes')->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/ogham/add/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }
        return $this->handle_request(new Ogham, $request);
    }

    /**
     * @Route("/admin/generator/ogham/addtype/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addTypeAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }
        return $this->handle_request(new OghamTypes, $request);
    }

    /**
     * @Route("/admin/generator/ogham/edit/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editAction(Ogham $ogham, Request $request)
    {
        return $this->handle_request($ogham, $request);
    }

    /**
     * @Route("/admin/generator/ogham/edittype/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editTypeAction(OghamTypes $oghamType, Request $request)
    {
        return $this->handle_request($oghamType, $request);
    }

    /**
     * @Route("/admin/generator/ogham/delete/{id}")
     * @Template()
     */
    public function deleteAction(Ogham $element)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->persist($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Ogham supprimé : <strong>'.$element->getName().'</strong>');
        return $this->redirect($this->generateUrl('corahnrin_characters_ogham_adminlist'));
    }

    /**
     * @Route("/admin/generator/ogham/deletetype/{id}")
     * @Template()
     */
    public function deleteTypeAction(OghamTypes $element)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->persist($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Type d\'Ogham supprimé : <strong>'.$element->getName().'</strong>');
        return $this->redirect($this->generateUrl('corahnrin_characters_ogham_adminlist'));
    }

    private function handle_request($element, Request $request) {
        $method = preg_replace('#^'.str_replace('\\','\\\\',__CLASS__).'::([a-zA-Z]+)Action$#isUu', '$1', $this->getRequest()->get('_controller'));
        $method = str_replace('Type','',$method);


        if (is_a($element, 'CorahnRin\CharactersBundle\Entity\Ogham')) {
            $type = false;
            $form = $this->createForm(new \CorahnRin\CharactersBundle\Form\OghamType(), $element);
        } elseif (is_a($element, 'CorahnRin\CharactersBundle\Entity\OghamTypes')) {
            $type = true;
            $form = $this->createForm(new \CorahnRin\CharactersBundle\Form\OghamTypesType(), $element);
        }

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', ($type?'Type d\'':'').'Ogham '.($method=='add'?'ajouté':'modifié').' : <strong>'.$element->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_characters_ogham_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method=='add'?'Ajouter':'Modifier').' un '.($type?'type d\'':'').'Ogham',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Ogham' => array('route'=>'corahnrin_characters_ogham_adminlist'),
            ),
        );
    }
}