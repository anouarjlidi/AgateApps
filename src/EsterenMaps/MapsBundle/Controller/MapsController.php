<?php

namespace EsterenMaps\MapsBundle\Controller;

//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Zones;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Form\MapsType;

class MapsController extends Controller
{

    /**
     * @Route("/maps/{id}-{nameSlug}", requirements={"id":"\d+"})
     * @Template()
     */
    public function viewAction(Maps $map) {
//        $route_init = $this->generateUrl('esterenmaps_maps_api_init');
        $route_init = '';
        return array('map'=>$map,'route_init' => $route_init);
    }

    /**
     * @Route("/maps/")
     * @Template()
     */
    public function indexAction() {
        $list = $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Maps')->findAll();
        return array('list' => $list);
    }

    /**
     * @Route("/admin/maps/add/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addAction(Request $request) {

        $map = new Maps();

        $form = $this->createForm(new MapsType, $map);

        if ($request->getMethod() == 'POST') {
            $form->submit($request);

            $pathinfo = $this->handleImage($map);

            if ($form->isValid()) {
                $pathinfo['file']->move($pathinfo['dir'], $pathinfo['path']);
                $em = $this->getDoctrine()->getManager();
                $em->persist($map);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'La carte <strong>'.$map->getName().'</strong> a été ajoutée');
                return $this->redirect($this->generateUrl('esterenmaps_maps_maps_adminlist'));
            }
        }

        return array(
            'form' => $form->createView(),
            'map' => $map,
            'title' => 'Créer une nouvelle carte',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Cartes' => array('route'=>'esterenmaps_maps_maps_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/edit/{id}")
     * @Template()
     */
    public function editAction(Maps $map, Request $request) {

        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == 'POST') {

            $this->updateZones($map, $request);
            $this->updateMarkers($map, $request);
            $this->updateRoutes($map, $request);

            $em->persist($map);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Modifications enregistrées !');
            return $this->redirect($this->generateUrl('esterenmaps_maps_maps_edit',array('id'=>$map->getId())));

        }

        $routesTypes = $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAll();
        $markersTypes = $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAll();

//        $route_init = $this->generateUrl('esterenmaps_maps_api_init');
        $route_init = '';

        $maxZones = $em->getRepository('EsterenMapsBundle:Zones')->getMax();
        $idsZones = $em->getRepository('EsterenMapsBundle:Zones')->getIds();

        $maxRoutes = $em->getRepository('EsterenMapsBundle:Routes')->getMax();
        $idsRoutes = $em->getRepository('EsterenMapsBundle:Routes')->getIds();

        $maxMarkers = $em->getRepository('EsterenMapsBundle:Markers')->getMax();
        $idsMarkers = $em->getRepository('EsterenMapsBundle:Markers')->getIds();

        return array(
            'map'=>$map,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
            'routesTypes' => $routesTypes,
            'markersTypes' => $markersTypes,
            'idsMarkers' => $idsMarkers,
            'idsZones' => $idsZones,
            'idsRoutes' => $idsRoutes,
            'emptyMarker' => new Markers(),
            'route_init' => $route_init,
            'maxZones' => $maxZones,
            'maxRoutes' => $maxRoutes,
            'maxMarkers' => $maxMarkers,
        );
    }

    /**
     * @Route("/admin/maps/edit_params/{id}")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function editParamsAction(Maps $map, Request $request) {
        $image = $map->getImage();
        $pathinfo = null;
        $map->setImage(null);
        $form = $this->createForm(new MapsType, $map);

        $form->handleRequest($request);

        if ($map->getImage()) {
            $pathinfo = $this->handleImage($map);
        } else {
            $map->setImage($image);
        }

        if ($form->isValid()) {

            if ($pathinfo) {
                $pathinfo['file']->move($pathinfo['dir'], $pathinfo['path']);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($map);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Carte modifiée : <strong>'.$map->getName().'</strong>');
            return $this->redirect($this->generateUrl('esterenmaps_maps_maps_adminlist'));
        }

        return array(
            'form' => $form->createView(),
            'title' => 'Modifier une carte',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_admin_admin_index',),
                'Cartes' => array('route'=>'esterenmaps_maps_maps_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/delete/{id}")
     * @Template()
     */
    public function deleteAction(Maps $map)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $map->setDeleted(1);
        $em->persist($map);
        $em->flush();

        $this->get('session')->getFlashBag()->add('success', 'La carte <strong>'.$map->getName().'</strong> a été correctement supprimée.');

        return $this->redirect($this->generateUrl('esterenmaps_maps_maps_adminlist'));
    }

    /**
     * @Route("/admin/maps/")
     * @Template()
     */
    public function adminListAction() {
        return array(
            'maps' => $this->getDoctrine()->getManager()->getRepository('EsterenMapsBundle:Maps')->findAll(),
        );
    }

    private function handleImage(&$map) {
        $file = $map->getImage();
        $basename = preg_replace('~\.[a-zA-Z0-9]+~isUu', '', $file->getClientOriginalName());
        $basename = preg_replace('~[^a-zA-Z0-9]~isUu', '_', $basename);
        $basename = preg_replace('~__+~', '_', $basename);
        $dir = ROOT.DS.'web'.DS.'uploads'.DS.'maps';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $ext = $file->guessExtension();
        $ext = $ext ? : 'bin';

        $final_path = $basename.'_'.rand(1, 99999999).'.'.$ext;

        $db_name = str_replace(ROOT.DS.'web'.DS, '', $dir.DS.$final_path);

        $final_image_name = str_replace('\\', '/', $db_name);

        $map->setImage($final_image_name);

        return array(
            'file' => $file,
            'dir' => $dir,
            'path' => $final_path,
        );
    }

    private function updateZones(&$map, Request $request) {
        $post = $request->request;

        $polygons_list = $post->get('map_add_zone_polygon');
        $names = $post->get('map_add_zone_name');

        $em = $this->getDoctrine()->getManager();

        $ids = array();
        foreach ($map->getZones() as $zone) {
            $ids[$zone->getId()] = $zone;
            $em->persist($zone);
        }

        foreach ($polygons_list as $id => $coordinates) {
            $zone = new Zones();
            // Définition de la zone
            $zone->setId($id)
                ->setName($names[$id])
                ->setMap($map)
                ->setCoordinates($coordinates);
            unset($ids[$id]);

            $getZone = $map->getZone($zone);
            if (!$getZone){
                // Injection dans la map si elle n'existe pas encore
                $map->addZone($zone);
                $em->persist($zone);
            } else {
                if ($getZone->getCoordinates() !== $zone->getCoordinates() ||
                    $getZone->getName() !== $zone->getName()) {
                    $getZone->setCoordinates($zone->getCoordinates());
                    $getZone->setName($zone->getName());
                    $map->setZone($getZone);
                    $em->persist($getZone);
                }
            }
        }

        if (!empty($ids)) {
            foreach ($ids as $zone) {
                $zone->setDeleted(1);
                $em->persist($zone);
                $map->removeZone($zone);
            }
        }
    }

    private function updateMarkers(&$map, Request $request) {
        $post = $request->request;

        $list = $post->get('map_add_marker_coords');
        $names = $post->get('map_add_marker_name');
        $types = $post->get('map_add_marker_type');

        $em = $this->getDoctrine()->getManager();

        $markersTypes = $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAll(true);

        $ids = array();
        foreach ($map->getMarkers() as $marker) {
            $ids[$marker->getId()] = $marker;
            $em->persist($marker);
        }

        if ($list) {
            foreach ($list as $id => $coordinates) {
                // Définition de la marker
                if (!isset($markersTypes[$types[$id]])) {
                    throw new \Symfony\Component\Config\Definition\Exception\Exception('Incorrect marker type');
                }
                $marker = new Markers();
                $marker->setId($id)
                    ->setName($names[$id])
                    ->setMap($map)
                    ->setMarkerType($markersTypes[$types[$id]])
                    ->setCoordinates($coordinates);
                unset($ids[$id]);

                $getMarker = $map->getMarker($marker);
                if (!$getMarker){
                    // Injection dans la map si elle n'existe pas encore
                    $map->addMarker($marker);
                    $em->persist($marker);
                } else {
                    if ($getMarker->getCoordinates() !== $marker->getCoordinates() ||
                        $getMarker->getName() !== $marker->getName()) {
                        $getMarker->setCoordinates($marker->getCoordinates())
                            ->setMarkerType($markersTypes[$types[$id]])
                            ->setName($marker->getName());
                        $map->setMarker($getMarker);
                        $em->persist($getMarker);
                    }
                }
            }

            if (!empty($ids)) {
                foreach ($ids as $marker) {
                    $marker->setDeleted(1);
                    $em->persist($marker);
                    $map->removeMarker($marker);
                }
            }
        }

    }

    private function updateRoutes(&$map, Request $request) {
        $post = $request->request;

        $polylines_list = $post->get('map_add_route_polyline');
        $names = $post->get('map_add_route_name');
        $types = $post->get('map_add_route_type');
        $starts = $post->get('map_add_route_start');
        $ends = $post->get('map_add_route_end');

        $em = $this->getDoctrine()->getManager();

        $routesTypes = $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAll(true);

        $ids = array();
        foreach ($map->getRoutes() as $route) {
            $ids[$route->getId()] = $route;
            $em->persist($route);
        }

        $markers_ids = array();
        foreach ($map->getMarkers() as $marker) {
            $markers_ids[$marker->getId()] = $marker;
            $em->persist($marker);
        }


        foreach ($polylines_list as $id => $coordinates) {
            $route = new Routes();

            // Définition de la route
            $route->setId($id)
                ->setName($names[$id])
                ->setMap($map)
                ->setRouteType($routesTypes[$types[$id]])
                ->setMarkerStart($markers_ids[$starts[$id]])
                ->setMarkerEnd($markers_ids[$ends[$id]])
                ->setCoordinates($coordinates);
            unset($ids[$id]);

            $getRoute = $map->getRoute($route);
            if (!$getRoute){
                // Injection dans la map si elle n'existe pas encore
                $map->addRoute($route);
                $em->persist($route);
            } else {
                if ($getRoute->getCoordinates() !== $route->getCoordinates() ||
                    $getRoute->getName() !== $route->getName()) {
                    $getRoute->setCoordinates($route->getCoordinates());
                    $getRoute->setName($route->getName());
                    $getRoute->setRouteType($route->getRouteType());
                    $getRoute->setMarkerStart($route->getMarkerStart());
                    $getRoute->setMarkerEnd($route->getMarkerEnd());
                    $map->setRoute($getRoute);
                    $em->persist($getRoute);
                }
            }
        }

        if (!empty($ids)) {
            foreach ($ids as $route) {
                $route->setDeleted(1);
                $em->persist($route);
                $map->removeRoute($route);
            }
        }
    }
}
