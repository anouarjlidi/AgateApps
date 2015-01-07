<?php

namespace Esteren\PortalBundle\Menu;

use EsterenMaps\MapsBundle\Entity\Maps;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class GeneralMenu extends ContainerAware {

    public function generalMenu(FactoryInterface $factory, array $options)
    {

        $menu = $factory->createItem('root', $options);

        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu
            ->addChild('Maps', array(
                'label' => 'Maps <b class="caret"></b>',
                'extras' => array('safe_label' => true),
            ))
            ->setAttributes(array('class' => 'dropdown'))
            ->setUri('#')
            ->setLinkAttributes(array('data-toggle' => 'dropdown', 'class' => 'dropdown-toggle'))
            ->setChildrenAttribute('class', 'dropdown-menu')
        ;

        /** @var Maps[] $maps */
        $maps = $this->container->get('doctrine')->getManager()->getRepository('EsterenMapsBundle:Maps')->findAll();
        foreach ($maps as $id => $map) {
            $menu['Maps']->addChild($map->getName(), array(
                'route' => 'esterenmaps_maps_maps_view',
                'routeParameters' => array(
                    'nameSlug' => $map->getNameSlug(),
                ),
            ));
        }

        return $menu;
    }

}