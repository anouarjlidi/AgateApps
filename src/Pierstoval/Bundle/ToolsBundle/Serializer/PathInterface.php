<?php

namespace Pierstoval\Bundle\ToolsBundle\Serializer;

interface PathInterface {

    /**
     * @return array
     */
    public function listenSerializePaths();

    /**
     * @return bool
     */
    public function isParsed();

    public function setParsed();

} 