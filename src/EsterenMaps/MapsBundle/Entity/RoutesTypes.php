<?php

namespace EsterenMaps\MapsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as Serializer;

/**
 * RoutesTypes.
 *
 * @ORM\Table(schema="maps", name="maps_routes_types")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 * @ORM\Entity(repositoryClass="EsterenMaps\MapsBundle\Repository\RoutesTypesRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class RoutesTypes
{
    use TimestampableEntity;
    use SoftDeleteableEntity;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Serializer\Expose
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false, unique=true)
     * @Serializer\Expose
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Serializer\Expose
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=75, nullable=true)
     * @Serializer\Expose
     */
    protected $color;

    /**
     * @var Resources[]
     * @ORM\ManyToMany(targetEntity="Resources", mappedBy="routesTypes")
     */
    protected $resources;

    /**
     * @var Routes[]
     * @ORM\OneToMany(targetEntity="Routes", mappedBy="routeType")
     */
    protected $routes;

    /**
     * @var RoutesTransports[]
     * @ORM\OneToMany(targetEntity="EsterenMaps\MapsBundle\Entity\RoutesTransports", mappedBy="routeType")
     * @Serializer\Expose
     */
    protected $transports;

    public function __toString()
    {
        return $this->id.' - '.$this->name;
    }

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->resources  = new ArrayCollection();
        $this->routes     = new ArrayCollection();
        $this->transports = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return RoutesTypes
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add resources.
     *
     * @param Resources $resources
     *
     * @return RoutesTypes
     */
    public function addResource(Resources $resources)
    {
        $this->resources[] = $resources;

        return $this;
    }

    /**
     * Remove resources.
     *
     * @param Resources $resources
     */
    public function removeResource(Resources $resources)
    {
        $this->resources->removeElement($resources);
    }

    /**
     * Get resources.
     *
     * @return Resources[]
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Add routes.
     *
     * @param Routes $routes
     *
     * @return RoutesTypes
     */
    public function addRoute(Routes $routes)
    {
        $this->routes[] = $routes;

        return $this;
    }

    /**
     * Remove routes.
     *
     * @param Routes $routes
     */
    public function removeRoute(Routes $routes)
    {
        $this->routes->removeElement($routes);
    }

    /**
     * Get routes.
     *
     * @return Routes[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     *
     * @return RoutesTypes
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return RoutesTypes
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Add transports.
     *
     * @param RoutesTransports $transports
     *
     * @return RoutesTypes
     */
    public function addTransport(RoutesTransports $transports)
    {
        $this->transports[] = $transports;

        return $this;
    }

    /**
     * Remove transports.
     *
     * @param RoutesTransports $transports
     *
     * @return RoutesTypes
     */
    public function removeTransport(RoutesTransports $transports)
    {
        $this->transports->removeElement($transports);

        return $this;
    }

    /**
     * Get transports.
     *
     * @return RoutesTransports[]
     */
    public function getTransports()
    {
        return $this->transports;
    }

    /**
     * @param TransportTypes $transportType
     *
     * @return RoutesTransports
     */
    public function getTransport(TransportTypes $transportType)
    {
        $transports = $this->transports->filter(function (RoutesTransports $element) use ($transportType) {
            return $element->getTransportType()->getId() === $transportType->getId();
        });

        if (!$transports->count()) {
            throw new \InvalidArgumentException('RouteType object should have all types of transports bound to it. Could not find: "'.$transportType.'".');
        }

        return $transports->first();
    }
}
