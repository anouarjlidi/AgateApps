<?php

namespace Pierstoval\Bundle\ToolsBundle\Serializer;

use EsterenMaps\MapsBundle\Entity\MarkersTypes;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;
use Pierstoval\Bundle\ToolsBundle\Twig\PathsExtension;
use Symfony\Component\Templating\Helper\CoreAssetsHelper;

class PathsHandler implements EventSubscriberInterface
{

    /** @var PathsExtension */
    private $pathsExtension;

    /** @var string */
    private $domainName;

    public function __construct(PathsExtension $pathsExtension, $domainName)
    {
        $this->pathsExtension = $pathsExtension;
        $this->domainName = $domainName;
    }

    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.pre_serialize', 'method' => 'onPostSerialize'),
        );
    }

    public function onPostSerialize(ObjectEvent $event)
    {
        $obj = $event->getObject();
        if ($obj instanceof MarkersTypes && $obj->getIconName()) {
            $obj->setIconName($this->serializePath($obj->getIconName()));
        }
    }

    private function serializePath($string)
    {
        return 'http://'.$this->domainName.$this->pathsExtension->absoluteToWebPath($string);
    }
}