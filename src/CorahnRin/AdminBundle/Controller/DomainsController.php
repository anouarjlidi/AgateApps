<?php

namespace CorahnRin\AdminBundle\Controller;

use CorahnRin\ModelsBundle\Entity\Domains;
use CorahnRin\ModelsBundle\Form\DomainsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DomainsController extends Controller {
    /**
     * @Route("/admin/generator/domains/")
     * @Template()
     */
    public function adminListAction() {
        $name = str_replace('Controller', '', preg_replace('#^([a-zA-Z]+\\\)*#isu', '', __CLASS__));
        return array(
            strtolower($name) => $this->getDoctrine()->getManager()->getRepository('CorahnRinModelsBundle:' . $name)->findAll(),
        );
    }

    /**
     * @Route("/admin/generator/domains/edit/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
     */
    public function editAction(Domains $domain, Request $request) {
        return $this->handle_request($domain, $request);
    }

    private function handle_request(Domains $element, Request $request) {
//        $method = preg_replace('#^' . str_replace('\\', '\\\\', __CLASS__) . '::([a-zA-Z]+)Action$#isUu', '$1', $request->get('_controller'));

        $form = $this->createForm(new DomainsType(), $element);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($element);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Domaine modifié : <strong>' . $element->getName() . '</strong>');
            return $this->redirect($this->generateUrl('corahnrin_admin_domains_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => 'Modifier un domaine',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Domaines' => array('route' => 'corahnrin_admin_domains_adminlist'),
            ),
        );
    }
}