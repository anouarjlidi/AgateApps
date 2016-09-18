<?php

namespace Pierstoval\Bundle\ToolsBundle\Twig;

/**
 * Allows using "dump" function even in prod (to be removed)
 * @todo Remove when not needed anymore.
 */
class DumpExtension extends \Twig_Extension
{
    /**
     * @var \Twig_Extension_Debug
     */
    private $debugExtension = false;

    public function setDebugExtension(\Twig_Extension_Debug $debugExtension = null)
    {
        $this->debugExtension = $debugExtension;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return $this->debugExtension->getFunctions();
    }

    /**
     * @return string
     */
    public function dump()
    {
        ob_start();

        if (function_exists('dump')) {
            dump(func_get_args());
        } else {
            var_dump(func_get_args());
        }

        return ob_get_clean();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dump';
    }
}
