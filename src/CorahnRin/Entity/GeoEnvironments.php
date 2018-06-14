<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\Entity;

use CorahnRin\Entity\Traits\HasBook;
use Doctrine\ORM\Mapping as ORM;

/**
 * GeoEnvironments.
 *
 * @ORM\Table(name="geo_environments")
 * @ORM\Entity(repositoryClass="CorahnRin\Repository\GeoEnvironmentsRepository")
 */
class GeoEnvironments
{
    use HasBook;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var Domains
     *
     * @ORM\ManyToOne(targetEntity="Domains")
     */
    protected $domain;

    public function __construct(int $id, string $name, string $description, Domains $domain)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->domain = $domain;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getDomain(): Domains
    {
        return $this->domain;
    }
}
