<?php

namespace EsterenMaps\MapsBundle\DoctrineListeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use EsterenMaps\MapsBundle\Entity\Markers;
use EsterenMaps\MapsBundle\Entity\MarkersTypes;
use EsterenMaps\MapsBundle\Entity\Routes;
use EsterenMaps\MapsBundle\Entity\RoutesTransports;
use EsterenMaps\MapsBundle\Entity\RoutesTypes;
use EsterenMaps\MapsBundle\Entity\TransportTypes;
use EsterenMaps\MapsBundle\Entity\Zones;
use EsterenMaps\MapsBundle\Entity\ZonesTypes;
use Symfony\Component\Filesystem\Filesystem;

class CacheClearSubscriber implements EventSubscriber
{

    /**
     * @var string
     */
    protected $directionsCacheDir;

    public function __construct($directionsCacheDir)
    {
        $this->directionsCacheDir = $directionsCacheDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'postPersist',
            'postUpdate',
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->clearCache($args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->clearCache($args);
    }

    private function clearCache(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        // Clear the map cache if the entity corresponds to a specific class.
        if ((
            $entity instanceof Routes
            || $entity instanceof RoutesTypes
            || $entity instanceof Markers
            || $entity instanceof MarkersTypes
            || $entity instanceof Zones
            || $entity instanceof ZonesTypes
            || $entity instanceof TransportTypes
            || $entity instanceof RoutesTransports
        ) && is_dir($this->directionsCacheDir)) {
            $fs = new Filesystem();
            $fs->remove($this->directionsCacheDir);
        }
    }
}
