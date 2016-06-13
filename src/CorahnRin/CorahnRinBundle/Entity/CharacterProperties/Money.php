<?php

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
     * @return mixed
     */
    public function getFrost()
    {
        return $this->frost;
    }

    /**
     * @param mixed $frost
     */
    public function setFrost($frost)
    {
        $this->frost = $frost;
    }

    /**
     * @return mixed
     */
    public function getAzure()
    {
        return $this->azure;
    }

    /**
     * @param mixed $azure
     */
    public function setAzure($azure)
    {
        $this->azure = $azure;
    }

    /**
     * @return mixed
     */
    public function getEmber()
    {
        return $this->ember;
    }

    /**
     * @param mixed $ember
     */
    public function setEmber($ember)
    {
        $this->ember = $ember;
    }

}
