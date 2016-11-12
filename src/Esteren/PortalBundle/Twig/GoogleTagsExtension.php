<?php

namespace Esteren\PortalBundle\Twig;

class GoogleTagsExtension extends \Twig_Extension
{
    /**
     * @var array
     */
    private $googleTags;

    /**
     * @var bool
     */
    private $debug;

    public function __construct(array $googleTags, $debug)
    {
        $this->googleTags = $googleTags;
        $this->debug      = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('get_gtm', [$this, 'getGoogleTagManager']),
            new \Twig_SimpleFunction('get_ga', [$this, 'getGoogleAnalytics']),
        ];
    }

    /**
     * @return string
     */
    public function getGoogleTagManager()
    {
        return $this->debug ? null : $this->googleTags['tag_manager'];
    }

    /**
     * @return string
     */
    public function getGoogleAnalytics()
    {
        return $this->debug ? null : $this->googleTags['analytics'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'google_tags';
    }
}
