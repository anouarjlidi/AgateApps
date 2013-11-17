<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use CorahnRin\MapsBundle\Entity\Maps;

class ApiController extends Controller {

    private $img_size = 0;
    private $json_params = 0;

    /**
     * @Route("/api/maps/tile/{id}/{zoom}/{x}/{y}", requirements={"id":"\d+"})
     */
    public function tileAction(Maps $map, $zoom, $x, $y) {
        $zoom = (int) $zoom;
        $x = (int) $x;
        $y = (int) $y;

        $response = new Response();

        $this->init();

        $id = $map->getId();

        $img_size = (int) $this->container->getParameter('corahn_rin_maps.tile_size');

        $tilesManager = new \CorahnRin\MapsBundle\Classes\MapsTileManager($map, $img_size);

        $console_dir = $this->get('kernel')->getRootDir().'/console';
        $cmd = 'php "'.$console_dir.'" corahnrin:generate:map-tile --replace '.$id.' -x '.$x.' -y '.$y.' -z '.$zoom;

//        var_dump($cmd);
        if (!file_exists($tilesManager->mapDestinationName($zoom, $x, $y))) {

            $command = $this->get('MapTileCommandService');
            $command->setContainer($this->container);

            $input = new \Symfony\Component\Console\Input\ArrayInput(array(
                'id'=>$id,
                '--x'=>$x,
                '--y'=>$y,
                '--zoom'=>$zoom,
                '--replace'=>true,
                '--no-interaction'=>true,
            ), $command->getDefinition());

            $output = new \Symfony\Component\Console\Output\ConsoleOutput($command->getName());

            $o = $command->run($input, $output);
            if ($o) {
                $translator = $this->get('corahn_rin_translate');
                $translator->routeTemplate('corahnrin_maps_api_errors');
                $response->headers->set('Content-type', 'application/json');
                $response->setContent(json_encode(array(
                    'error' => $o,
                    'message' => $translator->translate('L\'image n\'a pas pu être créée correctement'),
                ), $this->json_params));
                $translator->routeTemplate();
                return $response;
            }
        }

        $response->headers->set('Content-type', 'image/jpeg');
        $response->setContent(file_get_contents($tilesManager->mapDestinationName($zoom, $x, $y)));
        return $response;

//        $console_dir = $this->get('kernel')->getRootDir().'/console';
//        $cmd = 'php "'.$console_dir.'" corahnrin:generate:map-tile '.$id.' -x '.$x.' -y '.$y.' -z '.$z;


//        $input = new \Symfony\Component\Console\Input\ArgvInput($args);
//        $input->setOption('id', $id)
//            ->setOption('x', $x)
//            ->setOption('y', $y)
//            ->setOption('zoom', $zoom);
//        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
//
//        print_r($output);
//        return;
//
//        $command = $this->get('MapTileCommandService');
//        $command->execute($input, $ouput);

        return;

        return;

        $zoom = (int) $zoom;
        $x = (int) $x;
        $y = (int) $y;

        $this->init();

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-type','application/json');

        $id = (int) $id;
        $zoom = (int) $zoom;
        $x = (int) $x;
        $y = (int) $y;

        //Chargement de la carte associée
        $map = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findOneBy(array('id'=>$id));

        if (!$map) {
            return $this->quit('Aucune carte trouvée.');
        }

        $img = ROOT.'/web/'.$map->getImage();

        if (!file_exists($img)) {
            return $this->quit('L\'image n\'a pas été trouvée.');
        }

        if ($zoom <= 0 || $zoom > $map->getMaxZoom()) {
            return $this->quit('Cette valeur de zoom est indisponible pour cette carte.');
        }
        $ratio = $zoom / $map->getMaxZoom();

        //Récupération de la taille de l'image
        $cmd = 'identify -format "%wx%h" "'.$img.'"';

        $size = shell_exec($cmd);
        if (!$size || !preg_match('#^[0-9]+x[0-9]+$#', $size)) {
            return $this->quit('Erreur lors de l\'identification de l\'image');
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
            return $this->quit('Aucune tuile trouvée.');
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
                ' -quality 95'.//Une faible qualité réduira le poids des images
                ' -thumbnail '.$this->img_size.'x'.$this->img_size.
                ' "'.$imgname.'"';

            exec($cmd);
        }

        $response->setContent(file_get_contents($imgname));
        $response->headers->set('Content-type', 'image/jpeg');
        return $response;
    }

    /**
     * @Route("/api/maps/init", defaults={"_format":"json"})
     * @Method({"POST"})
     */
    public function initAction() {
        $this->init();

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-type','application/json');

        $id = $this->getRequest()->request->get('id');
        if (!$id) {
            $this->quit('Un identifiant doit être indiqué');
        }
        $map = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findOneBy(array('id'=>$id));

        if (!$map) {
            $this->quit('Aucune carte trouvée', 404);
        }

        $route_tiles = urldecode($this->generateUrl('corahnrin_maps_api_tile', array('zoom'=>'{zoom}','id'=>$map->getId(), 'x'=>'{x}','y'=>'{y}')));

        $datas = array(
            'id' => $map->getId(),
            'name' => $map->getName(),
            'nameSlug' => $map->getNameSlug(),
            'maxZoom' => $map->getMaxZoom(),
            'tilesUrl' => str_replace('{id}', $map->getId(), $route_tiles),
        );

        $response->setContent(json_encode($datas, $this->json_params));

        //Envoi des données au navigateur;
        return $response;
    }

    /*-------------------------------------------------------------------------
    ---------------------------------------------------------------------------
    ---------------------------- MÉTHODES INTERNES ----------------------------
    ---------------------------------------------------------------------------
    -------------------------------------------------------------------------*/

    private function init() {
        $this->json_params = JSON_NUMERIC_CHECK;
        if (version_compare(PHP_VERSION, '5.4.0', '>')) {
            $this->json_params = $this->json_params | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        }

        $this->img_size = (int) $this->container->getParameter('corahn_rin_maps.tile_size');
        if (!$this->img_size) {
            $this->exception('Aucune taille d\'image trouvée. Vous devez la configurer dans "corahn_rin_maps.tile_size".');
        }
    }

    private function quit($msg = '', $code = 200) {
        $response = new Response();
        $response->headers->set('Content-type', 'application/json');
        $msg = $this->get('corahnrin_translate')->translate($msg);
        $response->setContent(json_encode(array('error' => $msg), $this->json_params));
        $response->setStatusCode($code);
        return $response;
    }

    private function exception($msg) {
        $translator = $this->get('corahn_rin_translate');
        $translator->routeTemplate('corahnrin_maps_api_error');
        $msg = $translator->translate($msg);
        $translator->routeTemplate();
        throw new \Symfony\Component\Config\Definition\Exception\Exception($msg);
    }
}
