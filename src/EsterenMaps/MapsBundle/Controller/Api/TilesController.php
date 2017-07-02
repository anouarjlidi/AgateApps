<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Controller\Api;

use EsterenMaps\MapsBundle\Form\MapImageType;
use EsterenMaps\MapsBundle\Entity\Maps;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TilesController extends Controller
{
    /**
     * @Route("/maps/image/{id}", requirements={"id": "\d+"}, name="esterenmaps_generate_map_image")
     * @Cache(expires="+1 day", public=true)
     * @Method("GET")
     *
     * @param Request $request
     * @param Maps    $map
     *
     * @return Response
     */
    public function generateMapImageAction(Request $request, Maps $map)
    {
        $form = $this->createForm(new MapImageType());

        $form->handleRequest($request);
        $form->submit($request->query->all());
        if ($form->isValid()) {
            $data = $form->getData();
            try {
                return new BinaryFileResponse(
                    $this->get('esterenmaps')->getTilesManager()->setMap($map)->createImage($data['ratio'], $data['x'], $data['y'], $data['width'], $data['height'], $data['withImages']),
                    200,
                    ['Content-Type' => 'image/jpeg']
                );
            } catch (\Exception $e) {
                $message = '';
                do {
                    if ($message) {
                        $message .= "\n";
                    }
                    $message .= $e->getMessage();
                } while ($e = $e->getPrevious());

                return new JsonResponse([
                    'error'   => true,
                    'message' => $message,
                ], 400);
            }
        } else {
            $messages = [];
            foreach ($form->getErrors(true, true) as $error) {
                $field      = $error->getOrigin()->getName();
                $messages[] = $this->get('translator')->trans('field_error', ['%field%' => $field], 'validators').': '.$error->getMessage();
            }

            return new JsonResponse([
                'error'   => true,
                'message' => $messages,
            ], 400);
        }
    }

    /**
     * @Route("/maps/tile/{id}/{zoom}/{x}/{y}.jpg", requirements={"id": "\d+"}, name="esterenmaps_api_tiles")
     * @Cache(maxage="864000", expires="+10 days")
     *
     * @param Maps $map
     * @param int  $zoom
     * @param int  $x
     * @param int  $y
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function tileAction(Maps $map, $zoom, $x, $y)
    {
        $outputDirectory = $this->container->getParameter('esterenmaps.output_directory');

        $file = $outputDirectory.$map->getId().'/'.(int) $zoom.'/'.(int) $x.'/'.(int) $y.'.jpg';

        if (!file_exists($file)) {
            $file = $outputDirectory.'/empty.jpg';
        }

        return new BinaryFileResponse($file, 200, ['Content-Type' => 'image/jpeg']);
    }
}
