<?php

namespace Pierstoval\Bundle\ToolsBundle\Twig;


class PathsExtension extends \Twig_Extension {

    /**
     * @var string
     */
    private $rootDir;

    public function __construct($kernel_root_dir)
    {
        $this->rootDir = rtrim($kernel_root_dir, '/\\');
    }

    public function getName()
    {
        return 'pierstoval_tools_twig_paths';
    }

    public function getFunctions() {
        return array(
            'absoluteToWebPath' => new \Twig_SimpleFunction('absoluteToWebPath', array($this, 'absoluteToWebPath')),
        );
    }

    /**
     * @param string $path
     * @return string
     */
    public function absoluteToWebPath($path) {
        if (!file_exists($path) || strpos($path, 'http') !== false) {
            return $path;
        }
        $path = str_replace($this->rootDir, '', $path);
        if (preg_match('~^[^§]+/web/~isUu', $path)) {
            $path = preg_replace('~^[^§]+/web/~isUu', '/', $path);
        }
        if (strpos($path, 'http') === false) {
            $path = '/'.ltrim($path, '/');
        }
        return $path;
    }
}