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

    private $markersTypes;
    private $routesTypes;
    private $factions;

    /**
     * @Route("/maps/{id}-{nameSlug}", requirements={"id":"\d+"})
     * @Template()
     */
    public function viewAction(Maps $map) {

        $tilesUrl = $this->generateUrl('esterenmaps_maps_tiles_tile', array('id'=>0,'x'=>0,'y'=>0,'zoom'=>0), true);
        $tilesUrl = str_replace('0/0/0/0','{id}/{z}/{x}/{y}', $tilesUrl);
        $tilesUrl = preg_replace('~app_dev(_fast)\.php/~isUu', '', $tilesUrl);

        return array(
            'map' => $map,
            'tilesUrl' => $tilesUrl,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
        );
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
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
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
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
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

        $routesTypes = $em->getRepository('EsterenMapsBundle:RoutesTypes')->findAll(true);
        $markersTypes = $em->getRepository('EsterenMapsBundle:MarkersTypes')->findAll(true);
        $factions = $em->getRepository('EsterenMapsBundle:Factions')->findAll(true);

        $this->routesTypes = $routesTypes;
        $this->markersTypes = $markersTypes;
        $this->factions = $factions;

        if ($request->getMethod() == 'POST') {

            $this->updateMarkers($map, $request);
            $this->updateZones($map, $request);
            $this->updateRoutes($map, $request);

            $em->persist($map);

            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Modifications enregistrées !');
            return $this->redirect($this->generateUrl('esterenmaps_maps_maps_edit',array('id'=>$map->getId())));

        }

//        $route_init = $this->generateUrl('esterenmaps_maps_api_init');
        $route_init = '';

        $maxZones = $em->getRepository('EsterenMapsBundle:Zones')->getMax();
        $idsZones = $em->getRepository('EsterenMapsBundle:Zones')->getIds();

        $maxRoutes = $em->getRepository('EsterenMapsBundle:Routes')->getMax();
        $idsRoutes = $em->getRepository('EsterenMapsBundle:Routes')->getIds();

        $maxMarkers = $em->getRepository('EsterenMapsBundle:Markers')->getMax();
        $idsMarkers = $em->getRepository('EsterenMapsBundle:Markers')->getIds();

        $tilesUrl = $this->generateUrl('esterenmaps_maps_tiles_tile', array('id'=>0,'x'=>0,'y'=>0,'zoom'=>0), true);
        $tilesUrl = str_replace('0/0/0/0','{id}/{z}/{x}/{y}', $tilesUrl);
		$tilesUrl = preg_replace('~app_dev(_fast)\.php/~isUu', '', $tilesUrl);

        return array(
            'map' => $map,
            'tilesUrl' => $tilesUrl,
            'tile_size' => $this->container->getParameter('esterenmaps.tile_size'),
            'routesTypes' => $routesTypes,
            'markersTypes' => $markersTypes,
            'factions' => $factions,
            'idsMarkers' => ++$idsMarkers,
            'idsZones' => ++$idsZones,
            'idsRoutes' => ++$idsRoutes,
            'emptyMarker' => new Markers(),
            'route_init' => $route_init,
            'maxZones' => $maxZones,
            'maxRoutes' => $maxRoutes,
            'maxMarkers' => $maxMarkers,
        );
    }

    /**
     * @Route("/admin/maps/edit_params/{id}")
     * @Template("PierstovalAdminBundle:Form:add.html.twig")
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
                'Accueil' => array('route' => 'pierstoval_admin_admin_index',),
                'Cartes' => array('route'=>'esterenmaps_maps_maps_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/delete/{id}")
     */
    public function deleteAction(Maps $map)
    {
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN_MAPS_SUPER')) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($map);
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

    private function handleImage(Maps &$map) {
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

    private function updateZones(Maps &$map, Request $request) {
        $post = $request->request;

        $polygons = $post->get('polygon');

        $em = $this->getDoctrine()->getManager();

        $zones_map = array();
        foreach ($map->getZones() as $zone) {
            $zones_map[$zone->getId()] = $zone;
            $em->persist($zone);
        }

        foreach ($polygons as $id => $polygon) {
            if (isset($zones_map[$id])) {
                $zone = $zones_map[$id];
            } else {
                $zone = new Zones();
            }

            // Définition de la zone
            $zone->setName($polygon['name'])
                ->setMap($map)
                ->setFaction($this->factions[$polygon['faction']])
                ->setCoordinates($polygon['coordinates']);
            unset($zones_map[$id]);

            $em->persist($zone);

        }

        // Suppression des zones absentes des données POST
        foreach ($zones_map as $zone) {
            $map->removeZone($zone);
            $em->remove($zone);
        }

    }

    private function updateMarkers(Maps &$map, Request $request) {
        $post = $request->request;

        $markers_post = $post->get('marker');
        $t = $map->getMarkers();
        $markers_map = array();
        foreach ($t as $m) { $markers_map[$m->getId()] = $m; }

        $em = $this->getDoctrine()->getManager();

        if (!$markers_post) { $markers_post = array(); }

        // Mise à jour des marqueurs
        foreach ($markers_post as $id => $marker_post) {
            if (isset($markers_map[$id])) {
                $marker = $markers_map[$id];
            } else {
                $marker = new Markers();
            }
            $marker
                ->setName($marker_post['name'])
                ->setAltitude($marker_post['altitude'])
                ->setLatitude($marker_post['latitude'])
                ->setLongitude($marker_post['longitude'])
                ->setMarkerType($this->markersTypes[$marker_post['type']])
                ->setMap($map)
            ;
            if ($marker_post['faction']) {
                $marker->setFaction($this->factions[$marker_post['faction']]);
                $em->persist($this->factions[$marker_post['faction']]);
            } else {
                $marker->setFaction(null);
            }
            $em->persist($marker);
        }

        // Suppression des marqueurs absents des données POST
        foreach ($markers_map as $marker) {
            $id = $marker->getId();
            if (!isset($markers_post[$id])) {
                $map->removeMarker($marker);
                $em->remove($marker);
            }
        }

    }

    private function updateRoutes(Maps &$map, Request $request) {
        $post = $request->request;

        $polylines = $post->get('polyline');

        $em = $this->getDoctrine()->getManager();

        $routes_map = array();
        foreach ($map->getRoutes() as $route) {
            $routes_map[$route->getId()] = $route;
            $em->persist($route);
        }

        $markers_ids = array();
        foreach ($map->getMarkers() as $marker) {
            $markers_ids[$marker->getId()] = $marker;
            $em->persist($marker);
        }


        foreach ($polylines as $id => $polyline) {
            if (isset($routes_map[$id])) {
                $route = $routes_map[$id];
            } else {
                $route = new Routes();
            }

            // Définition de la route
            $route->setName($polyline['name'])
                ->setMap($map)
                ->setRouteType($this->routesTypes[$polyline['type']])
                ->setFaction($polyline['faction'] ? $this->factions[$polyline['faction']] : null)
                ->setMarkerStart($markers_ids[$polyline['markerStart']])
                ->setMarkerEnd($markers_ids[$polyline['markerEnd']])
                ->setCoordinates($polyline['coordinates']);
            unset($routes_map[$id]);

            $em->persist($route);

        }

        // Suppression des routes absentes des données POST
        foreach ($routes_map as $route) {
            $map->removeRoute($route);
            $em->remove($route);
        }

    }
}
