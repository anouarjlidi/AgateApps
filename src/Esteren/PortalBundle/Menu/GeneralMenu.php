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
        $maps = $this->container->get('doctrine')->getManager()->getRepository('EsterenMapsBundle:Maps')->findAllArray();
        foreach ($maps as $map) {
            $menu['Maps']->addChild($map['name'], array(
                'route' => 'esterenmaps_maps_maps_view',
                'routeParameters' => array(
                    'nameSlug' => $map['nameSlug'],
                ),
            ));
        }

        return $menu;
    }

}