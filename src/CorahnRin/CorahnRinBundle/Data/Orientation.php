<?php

namespace CorahnRin\CorahnRinBundle\Data;

final class Orientation implements DataInterface
{
    const INSTINCTIVE = 'character.orientation.instinctive';

    const RATIONAL = 'character.orientation.rational';

    /**
     * Don't allow construction of this class.
     */
    private function __construct()
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getData()
    {
        return [
            static::INSTINCTIVE => [
                'name'        => 'Instinctive',
                'description' => 'L\'Instinct concerne toute l\'énergie pulsionnelle d\'un être vivant. Cet Aspect regroupe notamment les instincts de survie et d\'autoconservation ainsi que tout ce qui a trait à la sexualité.',
            ],
            static::RATIONAL => [
                'name'        => 'Rationnelle',
                'description' => 'Cet Aspect rend compte de l\'importance de la rationalité pour le PJ, de son ancrage dans la réalité, de sa capacité de logique et de réflexion, et de sa solidité.',
            ],
        ];
    }
}
