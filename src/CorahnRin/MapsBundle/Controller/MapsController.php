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
     * @Route("/maps/tile/{id}/{x}/{y}", requirements={"id":"\d+","x":"\d+","y":"\d+"})
     * @Template("CorahnRinMapsBundle:Maps:tile.json.twig")
     */
    public function tileAction($id, $x, $y){
        $x = (int) $x;
        $y = (int) $y;

        //Chargement de la carte associée
        $map = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findOneBy(array('id'=>$id));

        $err = false;//Aucune erreur

        //Récupération de la taille de l'image
        $cmd = 'identify -format "%wx%h" "'.ROOT.'/web/'.$map->getImage().'"';
        $size = shell_exec($cmd);
        list($w, $h) = explode('x',$size);

        $w = (int) $w;
        $h = (int) $h;

        $xmax = $w / 256;
        $ymax = $h / 256;

        if ((int)$xmax < $xmax) { $xmax = ((int) $xmax) + 1; }
        if ((int)$ymax < $ymax) { $ymax = ((int) $ymax) + 1; }

        while ($x > $xmax) { $x -= $xmax; }
        while ($y > $ymax) { $y -= $ymax; }

        while ($x < 0) { $x += $xmax; }
        while ($y < 0) { $y += $ymax; }
        
        $imgname = ROOT.'/app/cache/maps_img/'.$map->getNameSlug().'_'.$x.'_'.$y.'.jpg';
        
        if (!file_exists($imgname)) {
            if (!is_dir(dirname($imgname))) { mkdir(dirname($imgname), 0777, true); }
            $x *= 256;
            $y *= 256;
            $cmd = 'convert '.
                    '"'.ROOT.'/web/'.$map->getImage().
                    '" -crop 256x256+'.$x.'+'.$y.
                    ' -background black'.
                    ' -extent 256x256^ '.
                    '"'.$imgname.'"';
            exec($cmd);
        }

        
        $response = new Response(file_get_contents($imgname), 200, array('Content-type','image/jpeg'));
        $response->headers->set('Content-type', 'image/jpeg');
        return $response;
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
                $dir = ROOT.DS.'web'.DS.'bundles'.DS.'corahnrinmaps'.DS.'img';
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
