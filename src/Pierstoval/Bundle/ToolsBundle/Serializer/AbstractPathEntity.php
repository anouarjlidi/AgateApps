<?php

namespace Pierstoval\Bundle\ToolsBundle\Serializer;

class AbstractPathEntity implements PathInterface {

    protected $parsed = false;

    public function isParsed()
    {
        return $this->parsed;
    }

    public function setParsed()
    {
        $this->parsed = true;
    }

    public function listenSerializePaths() {
        throw new \Exception('You must define the listenSerializePaths() method in order to serialize your paths.');
    }

}
