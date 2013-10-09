<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CorahnRin\MapsBundle\Entity\Maps;
use CorahnRin\MapsBundle\Form\MapsType;

class MapsController extends Controller
{
    /**
     * @Route("/marker")
     * @Template()
     */
    public function viewAction()
    {
    }

    /**
     * @Route("/create")
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
                
                $db_name = str_replace(ROOT.DS.'web'.DS, '', $dir.DS.$final_name);
                
                $map->setImage($db_name);

                if ($form->isValid()) {
                    $valid = true;
                    $file->move($dir, $final_path);
                    //$em = $this->getDoctrine()->getManager();
                    //$em->persist($map);
                    //$em->flush();
                }
        }

        return array('form' => $form->createView(), 'map' => $map, 'valid' => $valid);
    }

    /**
     * @Route("/edit/{id}")
     * @Template()
     */
    public function editAction($id)
    {
    }

    /**
     * @Route("/delete/{id}")
     * @Template()
     */
    public function deleteAction($id)
    {
    }

}
