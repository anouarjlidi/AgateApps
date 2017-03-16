<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Model;

final class DirectionRouteTransport
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var float
     */
    private $speed;

    /**
     * @var float
     */
    private $percentage;

    /**
     * @var bool
     */
    private $ratioPositive;

    /**
     * @param int    $id
     * @param string $name
     * @param string $slug
     * @param float  $speed
     * @param float  $percentage
     * @param bool   $ratioPositive
     */
    public function __construct($id, $name, $slug, $speed, $percentage, $ratioPositive)
    {
        $this->id            = (int) $id;
        $this->name          = (string) $name;
        $this->slug          = (string) $slug;
        $this->speed         = (float) $speed;
        $this->percentage    = (float) $percentage;
        $this->ratioPositive = (bool) $ratioPositive;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return float
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @return bool
     */
    public function isRatioPositive()
    {
        return $this->ratioPositive;
    }
}
