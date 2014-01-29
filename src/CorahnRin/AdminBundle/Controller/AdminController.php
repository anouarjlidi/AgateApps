<?php

namespace CorahnRin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Route("/")
     * @Template("CorahnRinAdminBundle:Admin:layout.html.twig")
     */
    public function indexAction() {
        $controller = '';
        $params = array();
        return array(
            'controller' => $controller,
            '_params' => $params,
        );
    }

	/**
	 * @Template()
	 */
	public function menuAction($route) {
        $links = array(
            'Tableau de bord' => array(
                '_route' => 'corahnrin_admin_admin_index',
                '_params'=>array(),
            ),
            'Profil' => array(
                'Éditer' => array(
                    '_route' => 'fos_user_profile_edit',
                    '_params' => array(),
                ),
                'Voir' => array(
                    '_route' => 'fos_user_profile_show',
                    '_params' => array(),
                ),
            ),
        );
        $context = $securityContext = $this->container->get('security.context');
        if ($context->isGranted('ROLE_ADMIN_MAPS')) {
            $links['Esteren Maps'] = array(
                'Cartes' => array(
                    '_route' => 'corahnrin_maps_maps_adminlist',
                ),
                'Marqueurs' => array(
                    '_route' => 'corahnrin_maps_markers_adminlist',
                ),
                'Factions' => array(
                    '_route' => 'corahnrin_maps_factions_adminlist',
                ),
            );
        }
		return array(
            'links' => $links,
            'route' => $route,
        );
	}
}
