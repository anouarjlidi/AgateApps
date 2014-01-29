<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CorahnRin\MapsBundle\Entity\Maps;
use CorahnRin\MapsBundle\Entity\Zones;
use CorahnRin\MapsBundle\Entity\Routes;
use CorahnRin\MapsBundle\Form\MapsType;

class MapsController extends Controller
{

    /**
     * @Route("/maps/{id}-{nameSlug}", requirements={"id":"\d+"})
     * @Template()
     */
    public function viewAction(Maps $map) {
        $route_init = $this->generateUrl('corahnrin_maps_api_init');
        return array('map'=>$map,'route_init' => $route_init);
    }

    /**
     * @Route("/maps/")
     * @Template()
     */
    public function indexAction() {
        $list = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findAll();
        return array('list' => $list);
    }

    /**
     * @Route("/admin/maps/add/")
     * @Template("CorahnRinAdminBundle:Form:add.html.twig")
     */
    public function addAction() {

        $map = new Maps();

        $form = $this->createForm(new MapsType, $map);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
            $form->bind($request);
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

            $entity_image_name = str_replace('\\', '/', $db_name);

            $map->setImage($entity_image_name);

            if ($form->isValid()) {
                $file->move($dir, $final_path);
                $em = $this->getDoctrine()->getManager();
                $em->persist($map);
                $em->flush();
                return $this->redirect($this->generateUrl('corahnrin_maps_maps_adminlist'));
            }
        }

        return array(
            'form' => $form->createView(),
            'map' => $map,
            'title' => 'Créer une nouvelle carte',
            'breadcrumbs' => array(
                'Accueil' => array('route' => 'corahnrin_pages_pages_index',),
                'Cartes' => array('route'=>'corahnrin_maps_maps_adminlist'),
            ),
        );
    }

    /**
     * @Route("/admin/maps/edit/{id}")
     * @Template()
     */
    public function editAction(Maps $map) {

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {

            $em = $this->getDoctrine()->getManager();

            $this->updateZones($map);

            $em->persist($map);

            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Modifications enregistrées !');

        }
        $route_init = $this->generateUrl('corahnrin_maps_api_init');
        $max = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Zones')->getMax();
        return array('map'=>$map,'route_init' => $route_init, 'max' => $max);
    }

    /**
     * @Route("/admin/maps/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
        return new Response('Maps delete action : '.$id);
    }

    /**
     * @Route("/admin/maps/")
     * @Template()
     */
    public function adminListAction() {
        return array(
            'maps' => $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findAll(),
        );
    }

    private function updateZones(&$map) {
        $post = $this->get('request')->request;

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
                $em->persist($zone);
                $map->removeZone($zone);
                $em->remove($zone);
            }
        }
    }

    private function updateRoutes(&$map) {
        $post = $this->get('request')->request;

        $polylines_list = $post->get('map_add_route_polyline');
        $names = $post->get('map_add_route_name');

        $em = $this->getDoctrine()->getManager();

        $ids = array();
        foreach ($map->getRoutes() as $route) {
            $ids[$route->getId()] = $route;
            $em->persist($route);
        }

        foreach ($polylines_list as $id => $coordinates) {
            $route = new Routes();
            // Définition de la route
            $route->setId($id)
                ->setName($names[$id])
                ->setMap($map)
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
                    $map->setRoute($getRoute);
                    $em->persist($getRoute);
                }
            }
        }

        if (!empty($ids)) {
            foreach ($ids as $route) {
                $em->persist($route);
                $map->removeRoute($route);
                $em->remove($route);
            }
        }
    }
}
