<?php

namespace CorahnRin\AdminBundle\Controller;

use \CorahnRin\ModelsBundle\Entity\Books;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BooksController extends Controller
{
    /**
     * @Route("/admin/generator/books/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller','',preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinCharactersBundle:'.$name)->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/books/add/")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }
        return $this->handle_request(new Books, $request);
    }

    /**
     * @Route("/admin/generator/books/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Books $book, Request $request)
    {
        return $this->handle_request($book, $request);
    }

    /**
     * @Route("/admin/generator/books/delete/{id}")
     * @Template()
     */
    public function deleteAction(Books $element)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_GENERATOR_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($element);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'Livre supprimé : <strong>'.$element->getName().'</strong>');
        return $this->redirect($this->generateUrl('corahnrin_admin_books_adminlist'));
    }

    private function handle_request(Books $element) {
        $method = preg_replace('#^'.str_replace('\\','\\\\',__CLASS__).'::([a-zA-Z]+)Action$#isUu', '$1', $this->getRequest()->get('_controller'));

        $form = $this->createForm(new \CorahnRin\ModelsBundle\Form\BooksType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Livre '.($method=='add'?'ajouté':'modifié').' : <strong>'.$element->getName().'</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_books_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => ($method=='add'?'Ajouter':'Modifier').' un Livre',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Livres' => array('route'=>'corahnrin_admin_books_adminlist'),
            ),
        );
    }
}
