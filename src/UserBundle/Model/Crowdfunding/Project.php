<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Model\Crowdfunding;

class Project
{
    const ULULE = 'ulule';

    private $id;
    private $name;
    private $absoluteUrl;
    private $imageUrl;
    private $slug;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->slug = $data['slug'];
        $this->imageUrl = $data['image'];
        $this->absoluteUrl = $data['absolute_url'];
        $this->name = $data['name_fr'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAbsoluteUrl(): string
    {
        return $this->absoluteUrl;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
