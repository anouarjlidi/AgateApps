<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation\ExclusionPolicy as ExclusionPolicy;
use JMS\Serializer\Annotation\Expose as Expose;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Maps
 *
 * @ORM\Table(name="maps_routes_transports")
 * @Gedmo\SoftDeleteable(fieldName="deleted")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\MapsRepository")
 * @ExclusionPolicy("all")
 */
class RoutesTransports
{

    use TimestampableEntity;

    /**
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
     * @ORM\Column(name="percentage", type="float", scale=6, precision=6)
     * @Assert\NotNull()
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
     * @var integer
     *
     * @ORM\Column(name="deleted", type="datetime", nullable=true)
     */
    protected $deleted = null;

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

    /**
     * @return int
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param int $deleted
     *
     * @return RoutesTransports
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
        return $this;
    }

}

