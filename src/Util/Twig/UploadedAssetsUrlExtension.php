<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Util\Twig;

use Twig\Extension\AbstractExtension;

class UploadedAssetsUrlExtension extends AbstractExtension
{
    private $awsRegion;
    private $awsBucket;

    public function __construct(bool $debug, string $awsRegion, string $awsBucket)
    {
        $this->awsRegion = $awsRegion;
        $this->awsBucket = $awsBucket;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('uploaded_asset_url', [$this, 'assetUrl']),
        ];
    }

    public function assetUrl(string $assetName)
    {
        if ($this->awsBucket && $this->awsRegion) {
            return "https://s3-{$this->awsRegion}.amazonaws.com/{$this->awsBucket}/assets/$assetName";
        } else {
            return '/uploads/'.$assetName;
        }
    }
}
