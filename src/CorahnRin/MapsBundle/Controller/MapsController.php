<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CorahnRin\MapsBundle\Entity\Maps;
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
     * @Route("/admin/maps/")
     * @Template()
     */
    public function indexAction()
    {
        $list = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findAll();
        return array('list' => $list);
    }

    /**
     * @Route("/admin/maps/create")
     * @Template()
     */
    public function createAction()
    {
    
        $valid = false;
        $map = new Maps();

        $form = $this->createForm(new MapsType, $map);

        $request = $this->get('request');

        if ($request->getMethod() == 'POST') {
                $form->bind($request);
                $file = $map->getImage();
                $basename = preg_replace('~\.[a-zA-Z0-9]+~isUu', '', $file->getClientOriginalName());
                $basename = preg_replace('~[^a-zA-Z0-9]~isUu', '_', $basename);
                $basename = preg_replace('~__+~', '_', $basename);
                $dir = ROOT.DS.'web'.DS.'img'.DS.'maps';
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
                    $valid = true;
                    $file->move($dir, $final_path);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($map);
                    $em->flush();
                }
        }

        return array('form' => $form->createView(), 'map' => $map, 'valid' => $valid);
    }

    /**
     * @Route("/admin/maps/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
    }

    /**
     * @Route("/admin/maps/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
    }

}
