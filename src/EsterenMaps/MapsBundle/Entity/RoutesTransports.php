<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RoutesTransports
 *
 * @ORM\Table(name="maps_routes_transports", uniqueConstraints={@ORM\UniqueConstraint(name="unique_route_transport",columns={"route_type_id", "transport_type_id"})})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity()
 * @ExclusionPolicy("all")
 */
class RoutesTransports
{

    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     *
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    protected $id;

    /**
     * @var RoutesTypes
     * @ORM\ManyToOne(targetEntity="EsterenMaps\MapsBundle\Entity\RoutesTypes", inversedBy="transports")
     * @ORM\JoinColumn(name="route_type_id", nullable=false)
     * @Assert\NotNull()
     */
    protected $routeType;

    /**
     * @var TransportTypes
     * @ORM\ManyToOne(targetEntity="EsterenMaps\MapsBundle\Entity\TransportTypes")
     * @ORM\JoinColumn(name="transport_type_id", nullable=false)
     * @Assert\NotNull()
     * @Expose
     */
    protected $transportType;

    /**
     * @var float
     * @ORM\Column(name="percentage", type="decimal", scale=6, precision=9, nullable=false)
     * @Assert\NotNull()
     * @Assert\Range(max="100", min="0")
     * @Expose
     */
    protected $percentage;

    /**
     * @var boolean
     * @ORM\Column(name="positive_ratio", type="boolean", nullable=false)
     * @Assert\Type(type="boolean")
     * @Assert\NotNull()
     */
    protected $positiveRatio = false;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return RoutesTransports
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return RoutesTypes
     */
    public function getRouteType()
    {
        return $this->routeType;
    }

    /**
     * @param RoutesTypes $routeType
     *
     * @return RoutesTransports
     */
    public function setRouteType($routeType)
    {
        $this->routeType = $routeType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransportType()
    {
        return $this->transportType;
    }

    /**
     * @param mixed $transportType
     *
     * @return RoutesTransports
     */
    public function setTransportType($transportType)
    {
        $this->transportType = $transportType;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param mixed $percentage
     *
     * @return RoutesTransports
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isPositiveRatio()
    {
        return $this->positiveRatio;
    }

    /**
     * @param boolean $positiveRatio
     *
     * @return RoutesTransports
     */
    public function setPositiveRatio($positiveRatio)
    {
        $this->positiveRatio = $positiveRatio;

        return $this;
    }

}

