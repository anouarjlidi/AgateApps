<?php

namespace Esteren\PagesBundle\Controller;

use Esteren\PagesBundle\Entity\Menus;
use Esteren\PagesBundle\Form\MenusType;
use Esteren\PagesBundle\Repository\MenusRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class MenusController extends Controller {

    /**
     * @Template()
     */
    public function menuAction($route = '', $route_params = array()) {
        $masterRequest = $this->container->get('request_stack')->getMasterRequest();

        $domain = $masterRequest->getHost();

        if ($domain === $this->container->getParameter('esteren_domains.esteren_maps')) {
            $method_name = 'EsterenMaps';
            $brandTitle = 'Esteren Maps';
            $brandRoute = 'esterenmaps_maps_maps_index';
        } else {
            $method_name = 'CorahnRin';
            $brandTitle = 'Corahn-Rin';
            $brandRoute = 'root';
        }
        $links = $this->{'menu'.$method_name}();
        $langs = $this->container->get('pierstoval_translator')->getLangs();

        if (!$route) {
            $route = $masterRequest->attributes->get('_route');
        }

        return array(
            'links' => $links,
            'brandTitle' => $brandTitle,
            'brandRoute' => $brandRoute,
            'route_name' => $route,
            'locale' => $masterRequest->getLocale(),
            'langs' => $langs,
            'route_params' => $route_params ?: array(),
        );
    }

    protected function menuCorahnRin() {
        return array(
//            'corahnrin_generator_generator_index' => 'Générateur',
//            'corahnrin_characters_viewer_list' => 'Personnages',
            'esterenmaps_maps_maps_index' => 'Esteren Maps',
        );
    }

    protected function menuEsterenMaps() {
        $maps = $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Maps')->findAll(true);
        $maps_list = array();
        foreach ($maps as $id => $map) {
            $maps_list[$id] = array(
                'route' => 'esterenmaps_maps_maps_view',
                'name' => $map->getName(),
                'attributes' => array(
                    'id' => $map->getId(),
                    'nameSlug' => $map->getNameSlug(),
                ),
            );
        }
        $links = array(
            'dropdown_list_1' => array(
                'name' => 'Voir une carte',
                'list' => $maps_list,
            ),
            'root' => 'Corahn-Rin',
        );
        return $links;
    }

}
