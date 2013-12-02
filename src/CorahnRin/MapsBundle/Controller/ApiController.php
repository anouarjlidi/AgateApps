<?php

namespace CorahnRin\MapsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use CorahnRin\MapsBundle\Entity\Maps;
use CorahnRin\MapsBundle\Classes\MapsTileManager;

class ApiController extends Controller {

    private $img_size = 0;
    private $json_params = 0;

    /**
     * @Route("/api/maps/image/{id}", requirements={"id":"\d+"})
     */
    public function generateMapImage(Maps $map) {

        $response = new Response();
        $this->init();

        $tilesManager = new MapsTileManager($map, $this->img_size);

        $get_vars = $this->getRequest()->query;
        $dimensionsType = $get_vars->get('dimensions-type');
        $positionType = $get_vars->get('position-type');

        if (!$dimensionsType) { $dimensionsType = 'tile'; }
        if (preg_match('~^(t(iles?)?)$~isUu', $dimensionsType)) { $dimensionsType = 'tile'; }
        if (preg_match('~^(p(ixels?)?)$~isUu', $dimensionsType)) { $dimensionsType = 'pixel'; }

        if (!$positionType) { $positionType = 'tile'; }
        if (preg_match('~^(t(iles?)?)$~isUu', $positionType)) { $positionType = 'tile'; }
        if (preg_match('~^(p(ixels?)?)$~isUu', $positionType)) { $positionType = 'pixel'; }

        $x = (int) $get_vars->get('x') * ($positionType === 'tile' ? $this->img_size : 1);
        $y = (int) $get_vars->get('y') * ($positionType === 'tile' ? $this->img_size : 1);
        $z = (int) $get_vars->get('zoom');
        $w = (int) $get_vars->get('width') * ($dimensionsType === 'tile' ? $this->img_size : 1);
        $h = (int) $get_vars->get('height') * ($dimensionsType === 'tile' ? $this->img_size : 1);

        if (!$w) { $w = $this->img_size; }
        if (!$h) { $h = $this->img_size; }

        $imgname = $tilesManager->mapDestinationName($z, $x, $y, $w, $h);

        // Création de l'image personnalisée
        if (!file_exists($imgname)) { $tilesManager->createImage($z, $x, $y, $w, $h); }

        // Si l'image n'existe pas à ce stade c'est que la création a échoué
        if (!file_exists($imgname)) { return $this->quit('Erreur dans la création de l\'image.'); }

        $response->setContent(file_get_contents($imgname));

        $response->headers->set('Content-type', 'image/jpeg');
        return $response;
    }

    /**
     * @Route("/api/maps/tile/{id}/{zoom}/{x}/{y}", requirements={"id":"\d+"})
     */
    public function tileAction(Maps $map, $zoom, $x, $y) {
        $zoom = (int) $zoom;
        $x = (int) $x;
        $y = (int) $y;

        $response = new Response();

        $this->init();

        $create_tile = $this->generateTile($zoom, $x, $y);
        if (!is_bool($create_tile)) {
            //Si le retour de la création de tuile n'est pas un boolén c'est qu'il s'agit d'un objet Response
            //Dans ce cas, on le redirige au cas où une erreur est survenue.
            return $create_tile;
        }

        $id = $map->getId();

        $img_size = (int) $this->container->getParameter('corahn_rin_maps.tile_size');

        $tilesManager = new MapsTileManager($map, $img_size);

        $console_dir = $this->get('kernel')->getRootDir().'/console';
        $cmd = 'php "'.$console_dir.'" corahnrin:generate:map-tile --replace '.$id.' -x '.$x.' -y '.$y.' -z '.$zoom;

        $response->headers->set('Content-type', 'image/jpeg');
        $response->setContent(file_get_contents($tilesManager->mapDestinationName($zoom, $x, $y)));
        return $response;

    }

    /**
     * @Route("/api/maps/init/", defaults={"_format":"json"})
     * @Method({"POST"})
     */
    public function initAction() {
        $this->init();

        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-type','application/json');

        $id = $this->getRequest()->request->get('id');
        if (!$id) {
            return $this->quit('Un identifiant doit être indiqué');
        }
        $map = $this->getDoctrine()->getManager()->getRepository('CorahnRinMapsBundle:Maps')->findOneBy(array('id'=>$id));

        if (!$map) {
            return $this->quit('Aucune carte trouvée', 404);
        }

        $route_tiles = urldecode($this->generateUrl('corahnrin_maps_api_tile', array('zoom'=>'{zoom}','id'=>$map->getId(), 'x'=>'{x}','y'=>'{y}')));

        $img_size = $this->container->getParameter('corahn_rin_maps.tile_size');
        $tilesManager = new MapsTileManager($map, $img_size);

        $identifications = array();
        for ($i = 1; $i <= $map->getMaxZoom(); $i++) {
            $identifications[$i] = $tilesManager->identifyImage($i);
        }

        $datas = array(
            'id' => $map->getId(),
            'name' => $map->getName(),
            'nameSlug' => $map->getNameSlug(),
            'identifications' => $identifications,
            'maxZoom' => $map->getMaxZoom(),
            'imgSize' => $img_size,
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

    /**
     * Crée les paramètres json à utiliser et récupère le paramètre de la taille des tuiles
     */
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

    /**
     * Crée une tuile si elle n'existe pas déjà
     * @param integer $zoom
     * @param integer $x
     * @param integer $y
     */
    protected function generateTile($zoom, $x, $y) {

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
            $response = new Response();
            $response->headers->set('Content-type', 'application/json');
            $response->setContent(json_encode(array(
                'error' => $o,
                'message' => $translator->translate('L\'image n\'a pas pu être créée correctement'),
            ), $this->json_params));
            $translator->routeTemplate();
            return $response;
        }
        return true;
    }

    /**
     * Fais le rendu en JSON d'un message d'erreur et l'envoie au navigateur
     * @param string $msg
     * @param integer $code
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function quit($msg = '', $code = 200) {
        $response = new Response();
        $response->headers->set('Content-type', 'application/json');
        $msg = $this->get('corahnrin_translate')->translate($msg);
        $response->setContent(json_encode(array('error' => $msg), $this->json_params));
        $response->setStatusCode($code);
        return $response;
    }

    /**
     * Renvoie une exception traduite au navigateur.
     * @param type $msg
     * @throws \Symfony\Component\Config\Definition\Exception\Exception
     */
    private function exception($msg) {
        $translator = $this->get('corahn_rin_translate');
        $translator->routeTemplate('corahnrin_maps_api_error');
        $msg = $translator->translate($msg);
        $translator->routeTemplate();
        throw new \Symfony\Component\Config\Definition\Exception\Exception($msg);
    }
}
