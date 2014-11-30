<?php

namespace Pierstoval\Bundle\ToolsBundle\Serializer;

use Application\Sonata\MediaBundle\Entity\Media;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use Pierstoval\Bundle\ToolsBundle\Twig\PathsExtension;
use Sonata\MediaBundle\Model\MediaInterface;
use Sonata\MediaBundle\Provider\ImageProvider;

class PathsHandler implements EventSubscriberInterface
{

    /** @var PathsExtension */
    private $pathsExtension;

    /** @var string */
    private $domainName;

    /** @var bool */
    private $secure;

    /** @var ImageProvider */
    private $mediaProvider;

    public function __construct(PathsExtension $pathsExtension, $domainName, ImageProvider $mediaProvider, $secure = false)
    {
        $this->pathsExtension = $pathsExtension;
        $this->domainName = $domainName;
        $this->secure = $secure ? 's' : '';
        $this->mediaProvider = $mediaProvider;
    }

    public static function getSubscribedEvents()
    {
        return array(
            array('event' => 'serializer.post_serialize', 'method' => 'serializeMediaUrls'),
            array('event' => 'serializer.pre_serialize', 'method' => 'onPostSerialize'),
        );
    }

    public function serializeMediaUrls(ObjectEvent $event)
    {
        /** @var Media $obj */
        $obj = $event->getObject();

        /** @var \JMS\Serializer\JsonSerializationVisitor $visitor */
        $visitor = $event->getVisitor();
        if ($obj instanceof SerializableMediaUrl && $obj instanceof MediaInterface) {
            $formats = $this->mediaProvider->getFormats();
            $allFormats = array();
            foreach ($formats as $globalFormat => $formatContents) {
                if (strpos($globalFormat, $obj->getContext().'_') !== false) {
                    $format = str_replace($obj->getContext().'_', '', $globalFormat);
                    $allFormats[$format] = array_merge($formatContents, array('url' => $this->mediaProvider->generatePublicUrl($obj, $globalFormat)));
                }
            }
            $visitor->addData('url', $this->mediaProvider->generatePublicUrl($obj, 'reference'));
            $visitor->addData('formats', $allFormats);
        }
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