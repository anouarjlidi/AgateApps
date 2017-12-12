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

use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Repository\TransportTypesRepository;
use EsterenMaps\MapsBundle\Services\DirectionsManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class ApiDirectionsController extends AbstractController
{
    private $debug;
    private $versionCode;
    private $versionDate;
    private $transportTypesRepository;
    private $directionsManager;
    private $translator;

    public function __construct(
        bool $debug,
        string $versionCode,
        string $versionDate,
        TransportTypesRepository $transportTypesRepository,
        DirectionsManager $directionsManager,
        TranslatorInterface $translator
    ) {
        $this->debug = $debug;
        $this->versionCode = $versionCode;
        $this->versionDate = $versionDate;
        $this->transportTypesRepository = $transportTypesRepository;
        $this->directionsManager = $directionsManager;
        $this->translator = $translator;
    }

    /**
     * @Route("/maps/directions/{id}/{from}/{to}",
     *     name="esterenmaps_directions",
     *     requirements={"id": "\d+", "from": "\d+", "to": "\d+"},
     *     methods={"GET"}
     * )
     * @ParamConverter(name="from", class="EsterenMapsBundle:Markers", options={"id": "from"})
     * @ParamConverter(name="to", class="EsterenMapsBundle:Markers", options={"id": "to"})
     */
    public function getDirectionsAction(Maps $map, Markers $from, Markers $to, Request $request): JsonResponse
    {
        $code = 200;

        $transportId = $request->query->get('transport');
        $hoursPerDay = $request->query->get('hours_per_day', 7);
        $transport   = $this->transportTypesRepository->findOneBy(['id' => $transportId]);

        $etag = sha1('js'.$map->getId().$from->getId().$to->getId().$transportId.$this->versionCode);
        $lastModified = new \DateTime($this->versionDate);

        $response = new JsonResponse();
        if (!$this->debug || !$request->isNoCache()) {
            $response->setCache([
                'etag'          => $etag,
                'last_modified' => $lastModified,
                'max_age'       => 600,
                's_maxage'      => 600,
                'public'        => true,
            ]);
        }

        if ($response->isNotModified($request)) {
            return $response;
        }

        if (!$transport && $transportId) {
            $output = $this->getError($from, $to, $transportId, 'Transport not found.');
            $code   = 404;
        } else {
            $output = $this->directionsManager->getDirections($map, $from, $to, $hoursPerDay, $transport);
            if (!count($output)) {
                $output = $this->getError($from, $to);
                $code   = 404;
            }
        }

        $response->setData($output);
        $response->setStatusCode($code);

        return $response;
    }

    private function getError(Markers $from, Markers $to, int $transportId = null, string $message = 'No path found for this query.'): array
    {
        return [
            'error'   => true,
            'message' => $this->translator->trans($message),
            'query'   => [
                'from'      => $from,
                'to'        => $to,
                'transport' => $transportId,
            ],
        ];
    }
}
