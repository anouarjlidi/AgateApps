<?php

namespace EsterenMaps\ApiBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Services\MapsTilesManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TilesController extends Controller
{

    private $img_size = 0;

    /**
     * @Route("/maps/image/{id}", requirements={"id":"\d+"}, host="%esteren_domains.api%")
     * @param Request $request
     * @param Maps $map
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function generateMapImageAction(Request $request, Maps $map) {

        $response = new Response();
        $this->init();

        /** @var MapsTilesManager $tilesManager */
        $tilesManager = $this->container->get('esterenmaps.tiles_manager');

        $tilesManager->setMap($map);

        $get_vars = $request->query;
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
     * @Route("/api/maps/tile/{id}/{zoom}/{x}/{y}.jpg", requirements={"id":"\d+"}, host="%esteren_domains.esteren_maps%", name="esterenmaps_api_tiles_tile_local")
     * @Route("/maps/tile/{id}/{zoom}/{x}/{y}.jpg", requirements={"id":"\d+"}, host="%esteren_domains.api%", name="esterenmaps_api_tiles_tile_distant")
     * @Cache(maxage="864000", expires="+10 days")
     * @param Maps $map
     * @param integer $zoom
     * @param integer $x
     * @param integer $y
     * @throws \Exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tileAction(Maps $map, $zoom, $x, $y) {
        $zoom = (int) $zoom;
        $x = (int) $x;
        $y = (int) $y;

        $response = new Response();

        $this->init();

        $tilesManager = $this->container->get('esterenmaps.tiles_manager');

        $tilesManager->setMap($map);

        $imgname = $tilesManager->mapDestinationName($zoom, $x, $y);

        if (!file_exists($imgname)) {
            $ident = $tilesManager->identifyImage($zoom);
            if ($x < 0 || $y < 0 || $x > $ident['xmax'] || $y > $ident['ymax']) {
                $imgname = $this->get('kernel')->getCacheDir().'/maps/empty.jpg';
                if (!file_exists($imgname)) {
                    if (!is_dir(dirname($imgname))) {
                        mkdir(dirname($imgname), 0777, true);
                    }
                    $image = imagecreatetruecolor($this->img_size, $this->img_size);
                    imagefill($image, 0, 0, imagecolorallocate($image, 10, 10, 10));
                    header('Content-type:image/jpeg');
                    imagejpeg($image, $imgname, 0);
                    imagedestroy($image);
                }
            } else {
                $tilesManager->createTile($x, $y, $zoom, false, false);
            }
        }

        // Si l'image n'existe pas à ce stade c'est que la création a échoué
        if (!file_exists($imgname)) {
            return $this->quit('Erreur dans la création de l\'image.');
        }

        $response->headers->set('Content-type', 'image/jpeg');
        $response->setContent(file_get_contents($imgname));
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

        $this->img_size = (int) $this->container->getParameter('esterenmaps.tile_size');
        if (!$this->img_size) {
            $this->exception('Aucune taille d\'image trouvée. Vous devez la configurer dans "esterenmaps.tile_size".');
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
        $msg = $translator->translate($msg);
        $response->setContent(json_encode(array('error' => $msg), P_JSON_ENCODE));
        $response->setStatusCode($code);
        return $response;
    }

    /**
     * Renvoie une exception traduite au navigateur.
     * @param string $msg
     * @throws \Exception
     */
    private function exception($msg) {
        $translator = $this->get('translator');
        $msg = $translator->translate($msg);
        throw new \Exception($msg);
    }

}
