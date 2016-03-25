<?php

namespace Esteren\PortalBundle\Menu;

use EsterenMaps\MapsBundle\Entity\Maps;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * This menu is used for the global menu used throughout the whole application.
 * It intends to be simple and may depend on the request and container parameters to show other contents.
 *
 * This menu comes OUT of the "language" and "login/logout" sections on the left of the menu,
 *   which are hardcoded in the template.
 *
 * TODO: Remove the ContainerAwareInterface implementation when ContainerAwareTrait is well checked in the KnpMenuBundle.
 */
class GeneralMenu implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function getGeneralMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', $options);

        // Use bootstrap classes.
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        // Create the Maps dropdown menu.
        $menu
            ->addChild('Maps', [
                'label' => 'Maps <b class="caret"></b>',
                'extras' => ['safe_label' => true],
            ])
            ->setAttributes(['class' => 'dropdown'])
            ->setUri('#')
            ->setLinkAttributes(['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle'])
            ->setChildrenAttribute('class', 'dropdown-menu')
        ;

        // Add all maps to the Maps dropdown menu entry.
        $maps = $this->container->get('doctrine')->getManager()->getRepository('EsterenMapsBundle:Maps')->findForMenu();
        foreach ($maps as $map) {
            $menu['Maps']->addChild($map['name'], [
                'route' => 'esterenmaps_maps_maps_view',
                'routeParameters' => ['nameSlug' => $map['nameSlug']],
            ]);
        }

        return $menu;
    }
}
