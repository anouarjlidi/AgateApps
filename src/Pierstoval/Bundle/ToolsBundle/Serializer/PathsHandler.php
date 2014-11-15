<?php

namespace Pierstoval\Bundle\ToolsBundle\Serializer;

use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Pierstoval\Bundle\ToolsBundle\Twig\PathsExtension;

class PathsHandler implements EventSubscriberInterface
{

    /** @var PathsExtension */
    private $pathsExtension;

    /** @var string */
    private $domainName;

    /** @var bool */
    private $secure;

    public function __construct(PathsExtension $pathsExtension, $domainName, $secure = false)
    {
        $this->pathsExtension = $pathsExtension;
        $this->domainName = $domainName;
        $this->secure = $secure ? 's' : '';
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
        if ($obj instanceof AbstractPathEntity or $obj instanceof PathInterface) {
            foreach ($obj->listenSerializePaths() as $getter => $setter) {
                if ($obj->$getter() && !$obj->isParsed()) {
                    $obj->$setter($this->serializePath($obj->$getter()));
                    $obj->setParsed();
                }
            }
        }
    }

    /**
     * Generates a web path from an absolute path.
     * If no domain name is set in the configuration, it will generate a path from the root directory.
     * @param string $string Path to serialize
     * @return string
     */
    private function serializePath($string)
    {
        if ($this->domainName) {
            $str = 'http'.$this->secure.'://'.$this->domainName;
        } else {
            $str = '';
        }

        $str .= $this->pathsExtension->absoluteToWebPath($string);
        return $str;
    }
}