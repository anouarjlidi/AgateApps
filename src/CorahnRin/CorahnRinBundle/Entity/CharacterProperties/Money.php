<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Entity\CharacterProperties;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class Money
{
    protected static $name          = 'Daol';
    protected static $names         = ['Braise', 'Azur', 'Givre'];
    protected static $names_literal = ['Daol%s% de Braise', 'Daol%s% d\'Azur', 'Daol%s% de Givre'];
    protected static $ratio         = [10, 10, 10];
    protected static $values        = ['Braise' => 0, 'Azur' => 0, 'Givre' => 0];

    /**
     * @var int
     *
     * @ORM\Column(name="ember", type="integer")
     */
    protected $ember;

    /**
     * @var int
     *
     * @ORM\Column(name="azure", type="integer")
     */
    protected $azure;

    /**
     * @var int
     *
     * @ORM\Column(name="frost", type="integer")
     */
    protected $frost;

    /**
     * @param int  $ember
     * @param int  $azure
     * @param int  $frost
     * @param bool $flatten
     */
    public function __construct($ember = 0, $azure = 0, $frost = 0, $flatten = false)
    {
        $this->ember = (int) $ember;
        $this->azure = (int) $azure;
        $this->frost = (int) $frost;

        if ($flatten) {
            $this->flatten();
        }
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getFrost()
    {
        return $this->frost;
    }

    /**
     * @param int $frost
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function addFrost($frost)
    {
        $this->frost += $frost;

        return $this;
    }

    /**
     * @param int $frost
     *
     * @codeCoverageIgnore
     */
    public function setFrost($frost)
    {
        $this->frost = $frost;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getAzure()
    {
        return $this->azure;
    }

    /**
     * @param int $azure
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function addAzure($azure)
    {
        $this->azure += $azure;

        return $this;
    }

    /**
     * @param int $azure
     *
     * @codeCoverageIgnore
     */
    public function setAzure($azure)
    {
        $this->azure = $azure;
    }

    /**
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getEmber()
    {
        return $this->ember;
    }

    /**
     * @param int $ember
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function addEmber($ember)
    {
        $this->ember += $ember;

        return $this;
    }

    /**
     * @param int $ember
     *
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setEmber($ember)
    {
        $this->ember = $ember;

        return $this;
    }

    /**
     * @return Money
     */
    public function flatten()
    {
        // TODO

        return $this;
    }
}
