<?php

namespace EsterenMaps\Model;

use Symfony\Component\Validator\Constraints as Assert;

class MapImageQuery
{
    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     * @Assert\Range(min=1 max=100)
     */
    public $ratio = 100;

    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min=50)
     */
    public $width = 100;

    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     * @Assert\NotBlank
     * @Assert\Range(min=50)
     */
    public $height = 100;

    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     */
    public $x = 0;

    /**
     * @var int
     *
     * @Assert\Type(type="integer")
     */
    public $y = 0;

    /**
     * @var int
     *
     * @Assert\Type(type="bool")
     */
    public $withImages = true;
}
