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

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

/**
 * This form type is used to validate query parameters,
 *   when using the ApiTilesController with the API to generate an image.
 */
class MapImageType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ratio', IntegerType::class,
                [
                    'constraints' => [
                        new Type(['type' => 'integer']),
                        new Range(['min' => 1, 'max' => 100]),
                    ],
                ]
            )
            ->add('width', IntegerType::class,
                [
                    'constraints' => [
                        new Type(['type' => 'integer']),
                        new NotBlank(),
                        new Range(['min' => 50]),
                    ],
                ]
            )
            ->add('height', IntegerType::class,
                [
                    'constraints' => [
                        new Type(['type' => 'integer']),
                        new NotBlank(),
                        new Range(['min' => 50]),
                    ],
                ]
            )
            ->add('x', IntegerType::class, [
                'constraints' => [new Type(['type' => 'integer'])],
            ])
            ->add('y', IntegerType::class, [
                'constraints' => [new Type(['type' => 'integer'])],
            ])
            ->add('withImages', IntegerType::class, [
                'constraints' => [new Type(['type' => 'boolean'])],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data'            => [
                'withImages' => false,
                'ratio'      => 100,
                'width'      => 100,
                'height'     => 100,
            ],
        ]);
    }
}
