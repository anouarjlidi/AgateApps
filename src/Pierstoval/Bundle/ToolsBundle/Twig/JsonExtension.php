<?php

namespace Pierstoval\Bundle\ToolsBundle\Twig;

class JsonExtension extends \Twig_Extension
{

    /**
     * Returns the name of the extension.
     * @return string The extension name
     */
    public function getName()
    {
        return 'pierstoval_tools_twig_json';
    }

    public function getFilters()
    {
        return array(
             new \Twig_SimpleFilter('json_decode', array($this, 'jsonDecode')),
             new \Twig_SimpleFilter('json_encode', array($this, 'jsonEncode')),
        );
    }

    /**
     * @param string $str
     * @param bool   $object
     *
     * @return mixed
     */
    public function jsonDecode($str, $object = false)
    {
        return json_decode($str, $object);
    }

    /**
     * @param array $array
     * @param int   $flags
     *
     * @return string
     */
    public function jsonEncode($array, $flags = 480)
    {
        return json_encode($array, $flags);
    }
}
