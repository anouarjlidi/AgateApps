<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Form;

use EsterenMaps\MapsBundle\Constraints\Coordinates;
use EsterenMaps\MapsBundle\Entity\Factions;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\{CheckboxType, NumberType, TextareaType, TextType};
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

class ApiRouteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
        ;

        if ($options['display_coordinates']) {
            $builder->add('coordinates', TextareaType::class, [
                'constraints' => [
                    new Constraints\NotBlank(),
                    new Coordinates(),
                ],
            ]);
        }

        $builder
            ->add('forcedDistance', CheckboxType::class, [
                'constraints' => [
                    new Constraints\Type(['type' => 'bool']),
                ],
            ])
            ->add('guarded', CheckboxType::class, [
                'constraints' => [
                    new Constraints\Type(['type' => 'bool']),
                ],
            ])
            ->add('routeType', EntityType::class, [
                'class' => RoutesTypes::class,
            ])
            ->add('markerStart', EntityType::class, [
                'class' => Markers::class,
            ])
            ->add('markerEnd', EntityType::class, [
                'class' => Markers::class,
            ])
            ->add('faction', EntityType::class, [
                'class' => Factions::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $normalizer = function($o, $value) {
            $finalValues = [];

            foreach ($value as $k => $item) {
                $isArray = is_array($item);
                if ((!$isArray && !is_numeric($item)) || ($isArray && !isset($item['id']))) {
                    throw new \InvalidArgumentException('Items must at contain or be an id.');
                }
                $finalValues[$item['name'] ?? $item] = (int) ($item['id'] ?? $item);
            }

            ksort($finalValues);

            return $value;
        };

        $resolver
            ->setRequired('markers')
            ->setAllowedTypes('markers', 'array')
            ->setNormalizer('markers', $normalizer)

            ->setRequired('routes_types')
            ->setAllowedTypes('routes_types', 'array')
            ->setNormalizer('routes_types', $normalizer)

            ->setRequired('factions')
            ->setAllowedTypes('factions', 'array')
            ->setNormalizer('factions', $normalizer)

            ->setDefault('display_coordinates', false)
            ->setAllowedTypes('display_coordinates', 'bool')
            ->setDefault('data_class', Routes::class)
        ;
    }
}
