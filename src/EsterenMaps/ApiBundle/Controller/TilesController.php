<?php

namespace EsterenMaps\ApiBundle\Controller;

use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Services\MapsTilesManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TilesController extends Controller
{

    /**
     * @Route("/maps/image/{id}", requirements={"id":"\d+"}, host="%esteren_domains.api%", name="esterenmaps_generate_map_image")
     * @Cache(expires="+1 day", public=true)
     * @Method("GET")
     *
     * @param Request $request
     * @param Maps $map
     * @throws Exception
     * @return Response
     */
    public function generateMapImageAction(Request $request, Maps $map)
    {

        $response = new Response();

        // TODO: Refactor this method
        $response->setContent('Coming soon...');
        $response->headers->add(array('Content-Type' => 'text/plain'));
        return $response;

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
     * @Route("/maps/tile/{id}/{zoom}/{x}/{y}.jpg", requirements={"id":"\d+"}, host="%esteren_domains.api%", name="esterenmaps_api_tiles")
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

        $directory = $this->container->getParameter('esterenmaps.output_directory');

        $file = $directory.$map->getId().'/'.$zoom.'/'.$x.'/'.$y.'.jpg';

        if (!file_exists($file)) {
            $file = $directory.'/empty.jpg';
        }

        return new BinaryFileResponse($file, 200, array('Content-Type' => 'image/jpeg'));
    }

}
