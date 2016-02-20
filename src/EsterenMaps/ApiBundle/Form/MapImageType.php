<?php


namespace EsterenMaps\ApiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

/**
 * This form type is used to validate query parameters,
 *   when using the TilesController with the API to generate an image.
 */
class MapImageType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ratio', 'integer',
                [
                    'constraints' => [
                        new Type(['type' => 'integer']),
                        new Range(['min' => 1, 'max' => 100])
                    ]
                ]
            )
            ->add('width', 'integer',
                [
                    'constraints' => [
                        new Type(['type' => 'integer']),
                        new NotBlank(),
                        new Range(['min' => 50])
                    ]
                ]
            )
            ->add('height', 'integer',
                [
                    'constraints' => [
                        new Type(['type' => 'integer']),
                        new NotBlank(),
                        new Range(['min' => 50])
                    ]
                ]
            )
            ->add('x', 'integer', ['constraints' => [new Type(['type' => 'integer'])]])
            ->add('y', 'integer', ['constraints' => [new Type(['type' => 'integer'])]])
            ->add('withImages', 'checkbox', ['constraints' => [new Type(['type' => 'boolean'])]])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data' => [
                'withImages' => false,
                'ratio' => 100,
                'width' => 100,
                'height' => 100,
            ],
        ]);
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'esterenmaps_api_mapimage';
    }
}
