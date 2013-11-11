<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use CorahnRin\MapsBundle\Entity\Maps;
use CorahnRin\MapsBundle\Form\MapsType;

class ApiController extends Controller {
    
    private $img_size = 0;
    
    private function init(){
        $this->img_size = (int) $this->container->getParameter('corahn_rin_maps.tile_size');
        if (!$this->img_size) {
            return array('error' => 'Erreur dans la définition des images.');
        }
        return true;
    }

    /**
     * @Route("/api/maps/tile/{id}/{zoom}/{x}/{y}", requirements={"id":"\d+","x":"\d+","y":"\d+","zoom":"\d+"})
     * @Template("CorahnRinMapsBundle:Api:tile.json.twig")
     */
    public function tileAction($id, $zoom, $x, $y) {
        if (!$this->img_size) {
            $init = $this->init();
            if ($init !== true) {
                return $init;
            }
        }
        $id = (int) $id;
        $zoom = (int) $zoom;
        $x = (int) $x;
        $y = (int) $y;

        //Chargement de la carte associée
        $map = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findOneBy(array('id'=>$id));

        if (!$map) {
            return array('error' => 'Aucune carte trouvée.');
        }

        if ($zoom <= 0 || $zoom > $map->getMaxZoom()) {
            return array('error'=>'Cette valeur de zoom est indisponible pour cette carte.');
        }
        $ratio = $zoom / $map->getMaxZoom();

        //Récupération de la taille de l'image
        $cmd = 'identify -format "%wx%h" "'.ROOT.'/web/'.$map->getImage().'"';

        $size = shell_exec($cmd);
        if (!$size || !preg_match('#^[0-9]+x[0-9]+$#', $size)) {
            return array('error'=>'Erreur lors de l\'identification de l\'image');
        }
        list($w, $h) = explode('x',$size);

        //Sécurisation des valeurs et application du zoom
        $w = (int) $w * $ratio;
        $h = (int) $h * $ratio;

        //Calcul du nombre maximum de vignettes
        $xmax = $w / $this->img_size;
        $ymax = $h / $this->img_size;

        //Si les valeurs sont des floats, alors on accorde une vignette de plus
        //Celle-ci sera de toute façon comblée par du noir par ImageMagick
        // si elle ne remplit pas toute les dimensions
        if ((int)$xmax < $xmax) { $xmax = ((int) $xmax) + 1; }
        if ((int)$ymax < $ymax) { $ymax = ((int) $ymax) + 1; }
        
        $wmax = $xmax * $this->img_size;
        $hmax = $ymax * $this->img_size;
        
        //À ce stade, on a une image totale qui a pour dimensions ($xmax, $ymax)
        //De ce fait, si X ou Y est supérieur à ces valeurs, il n'y a pas de tuile dispo
        
        if ($x > $xmax || $x < 0 || $y > $ymax || $y < 0) {
            return array('error' => 'Aucune tuile trouvée.');
        }
        
        //Génération du nom de la tuile finale (dans le cache)
        $imgname = ROOT.'/app/cache/maps_img/'.$map->getNameSlug().'_'.$zoom.'_'.$x.'_'.$y.'.jpg';
        
        if (!file_exists($imgname)) {
            if (!is_dir(dirname($imgname))) { mkdir(dirname($imgname), 0777, true); }
            //Génération de l'offset à partir des X et Y demandés
            $x *= $this->img_size;
            $y *= $this->img_size;
            $ratio *= 100;

            //Commande ImageMagick
            $cmd = 'convert'.
                    ' "'.ROOT.'/web/'.$map->getImage().'"'.
                    ($ratio < 100 ? ' -resize '.$ratio.'%' : '').
                    ' -background black'.//Le "surplus" sera noirs
                    ' -extent '.$wmax.'x'.$hmax.'^'.//Redimensionne aux valeurs "width" et "height" maximales dépendant du zoom
                    ' -crop '.$this->img_size.'x'.$this->img_size.'+'.$x.'+'.$y.//Découpe l'image selon la taille demandée dans les paramètres
                    ' -extent '.$this->img_size.'x'.$this->img_size.'^'.//Et étend les éventuels pixels en trop ou en moins
                    ' "'.$imgname.'"';

//            \CorahnRinTools\pr($cmd);exit;

            exec($cmd);
        }

        $response = new Response(file_get_contents($imgname), 200);
        $response->headers->set('Content-type', 'image/jpeg');
        return $response;
    }

    /**
     * @Route("/api/maps/init/{id}", defaults={"_format":"json"}, requirements={"id":"\d+"})
     * @Template()
     */
    public function initAction(Maps $map) {
        $code = 200;//Code HTTP de la réponse, au cas où
        
        $datas = array(
            'id' => $map->getId(),
            'name' => $map->getName(),
            'nameSlug' => $map->getNameSlug(),
            'maxZoom' => $map->getMaxZoom(),
        );

        //Paramètres JSON (pour meilleure lisibilité)
        $json_params = JSON_NUMERIC_CHECK;
        if (version_compare(PHP_VERSION, '5.4.0', '>')) {
            $json_params = $json_params | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        }

        //Envoi des données au navigateur;
        return new Response(json_encode($datas, $json_params), $code, array('content-type'=>'application/json'));
    }

}
