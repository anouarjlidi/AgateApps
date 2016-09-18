<?php

namespace EsterenMaps\MapsBundle\Controller\Admin;

use AdminBundle\Controller\AdminController;
use EsterenMaps\MapsBundle\Entity\TransportModifiers;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;

class TransportTypesController extends AdminController
{
    /**
     * @Route("/", name="easyadmin")
     * {@inheritdoc}
     */
    public function indexAction(Request $request)
    {
        return parent::indexAction($request);
    }

    /**
     * Creates the form builder of the form used to create or edit the given entity.
     *
     * @param TransportTypes $entity
     * @param string         $view   The name of the view where this form is used ('new' or 'edit')
     *
     * @return FormBuilder
     */
    public function createTransportTypesEntityFormBuilder(TransportTypes $entity, $view)
    {
        // Get IDs in the entity and try to retrieve non-existing transport ids.
        $routesTypesIds = array_reduce(
            $entity->getTransportsModifiers()->toArray(),
            function (array $carry = [], TransportModifiers $routeTransport) {
                $carry[] = $routeTransport->getRouteType()->getId();

                return $carry;
            },
            []
        );

        $missingRoutesTypes = $this->em
            ->getRepository('EsterenMapsBundle:RoutesTypes')
            ->findNotInIds($routesTypesIds)
        ;

        foreach ($missingRoutesTypes as $routeType) {
            $entity->addTransportsModifier(
                (new TransportModifiers())
                    ->setTransportType($entity)
                    ->setRouteType($routeType)
            );
        }

        return parent::createEntityFormBuilder($entity, $view);
    }
}
