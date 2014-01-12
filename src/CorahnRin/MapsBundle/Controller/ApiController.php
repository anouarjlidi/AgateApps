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

        $identification = $tilesManager->identifyImage($z);

        if (!$w) { $w = $this->img_size; }
        if ($w > $identification['wmax']) { $w = $identification['wmax']; }
        if (!$h) { $h = $this->img_size; }
        if ($h > $identification['hmax']) { $h = $identification['hmax']; }


        if ($w > 1000) { $w = 1000; }
        if ($h > 1000) { $h = 1000; }

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

        $tilesManager = new MapsTileManager($map, $this->img_size);

        $imgname = $tilesManager->mapDestinationName($zoom, $x, $y);

        if (!file_exists($imgname)) {
            $tilesManager->createTile($x, $y, $zoom);
        }

        // Si l'image n'existe pas à ce stade c'est que la création a échoué
        if (!file_exists($imgname)) {
            return $this->quit('Erreur dans la création de l\'image.');
        }

        $response->headers->set('Content-type', 'image/jpeg');
        $response->setContent(file_get_contents($imgname));
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

        $response->setContent(json_encode($datas, P_JSON_ENCODE));

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

        $this->img_size = (int) $this->container->getParameter('corahn_rin_maps.tile_size');
        if (!$this->img_size) {
            $this->exception('Aucune taille d\'image trouvée. Vous devez la configurer dans "corahn_rin_maps.tile_size".');
        }
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
        $translator = $this->get('translator');
        $translator->translationDomain('error.api');
        $msg = $translator->translate($msg);
        $translator->translationDomain();
        $response->setContent(json_encode(array('error' => $msg), P_JSON_ENCODE));
        $response->setStatusCode($code);
        return $response;
    }

    /**
     * Renvoie une exception traduite au navigateur.
     * @param type $msg
     * @throws \Symfony\Component\Config\Definition\Exception\Exception
     */
    private function exception($msg) {
        $translator = $this->get('translator');
        $translator->translationDomain('error.api');
        $msg = $translator->translate($msg);
        $translator->translationDomain();
        throw new \Symfony\Component\Config\Definition\Exception\Exception($msg);
    }
}
