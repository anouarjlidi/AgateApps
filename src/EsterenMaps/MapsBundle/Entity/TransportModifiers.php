<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EsterenMaps\MapsBundle\Cache\EntityToClearInterface;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * TransportModifiers.
 *
 * @ORM\Table(name="maps_routes_transports", uniqueConstraints={@ORM\UniqueConstraint(name="unique_route_transport",columns={"route_type_id", "transport_type_id"})})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity()
 * @ExclusionPolicy("all")
 */
class TransportModifiers implements EntityToClearInterface
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    protected $id;

    /**
     * @var RoutesTypes
     *
     * @ORM\ManyToOne(targetEntity="EsterenMaps\MapsBundle\Entity\RoutesTypes", inversedBy="transports")
     * @ORM\JoinColumn(name="route_type_id", nullable=false)
     * @Assert\NotNull()
     */
    protected $routeType;

    /**
     * @var TransportTypes
     *
     * @ORM\ManyToOne(targetEntity="EsterenMaps\MapsBundle\Entity\TransportTypes", inversedBy="transportsModifiers")
     * @ORM\JoinColumn(name="transport_type_id", nullable=false)
     * @Assert\NotNull()
     * @Expose
     */
    protected $transportType;

    /**
     * @var float
     *
     * @ORM\Column(name="percentage", type="decimal", scale=6, precision=9, nullable=false, options={"default": "100"})
     * @Assert\NotNull()
     * @Assert\Range(max="100", min="0")
     * @Expose
     */
    protected $percentage = 100;

    /**
     * @var bool
     *
     * @ORM\Column(name="positive_ratio", type="boolean", nullable=false, options={"default": "1"})
     * @Assert\Type(type="boolean")
     * @Assert\NotNull()
     */
    protected $positiveRatio = true;

    public function __toString()
    {
        return (string)$this->transportType .
            ' - ' . $this->routeType .
            ' (' . ($this->positiveRatio ? 1 : -1) . $this->percentage . '%)';
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return TransportModifiers
     *
     * @codeCoverageIgnore
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return RoutesTypes
     *
     * @codeCoverageIgnore
     */
    public function getRouteType()
    {
        return $this->routeType;
    }

    /**
     * @param RoutesTypes $routeType
     *
     * @return TransportModifiers
     *
     * @codeCoverageIgnore
     */
    public function setRouteType($routeType)
    {
        $this->routeType = $routeType;

        return $this;
    }

    /**
     * @return TransportTypes
     *
     * @codeCoverageIgnore
     */
    public function getTransportType()
    {
        return $this->transportType;
    }

    /**
     * @param TransportTypes $transportType
     *
     * @return TransportModifiers
     *
     * @codeCoverageIgnore
     */
    public function setTransportType(TransportTypes $transportType)
    {
        $this->transportType = $transportType;

        return $this;
    }

    /**
     * @return float
     *
     * @codeCoverageIgnore
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param float $percentage
     *
     * @return TransportModifiers
     *
     * @codeCoverageIgnore
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPositiveRatio()
    {
        return $this->positiveRatio;
    }

    /**
     * @param bool $positiveRatio
     *
     * @return TransportModifiers
     *
     * @codeCoverageIgnore
     */
    public function setPositiveRatio($positiveRatio)
    {
        $this->positiveRatio = $positiveRatio;

        return $this;
    }
}
