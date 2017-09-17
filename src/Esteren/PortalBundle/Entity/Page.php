<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Esteren\PortalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Orbitale\Bundle\CmsBundle\Entity\Page as BasePage;

/**
 * @ORM\Entity(repositoryClass="Orbitale\Bundle\CmsBundle\Repository\PageRepository")
 * @ORM\Table(name="orbitale_cms_pages")
 */
class Page extends BasePage
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="show_title", type="boolean", options={"default": "1"})
     */
    private $showTitle = true;

    /**
     * @var string
     *
     * @ORM\Column(name="container_css_class", type="string", nullable=true)
     */
    private $containerCssClass;

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return Page
     *
     * @codeCoverageIgnore
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function getShowTitle()
    {
        return $this->showTitle;
    }

    /**
     * @param bool $showTitle
     *
     * @return Page
     *
     * @codeCoverageIgnore
     */
    public function setShowTitle($showTitle)
    {
        $this->showTitle = $showTitle;

        return $this;
    }

    /**
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getContainerCssClass()
    {
        return $this->containerCssClass;
    }

    /**
     * @param string $containerCssClass
     *
     * @return Page
     *
     * @codeCoverageIgnore
     */
    public function setContainerCssClass($containerCssClass)
    {
        $this->containerCssClass = $containerCssClass;

        return $this;
    }
}
