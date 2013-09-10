<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Table(name="disorders_ways")
 * @ORM\Entity
 */
class DisordersWays
{
    /**
     * @var \Disorders
     *
     * @ORM\Column(name="id_disorders", type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Disorders")
     */
    private $disorder;

    /**
     * @var \Ways
     *
     * @ORM\Column(name="id_ways", type="integer")
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Ways")
     */
    private $way;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_major", type="boolean")
     */
    private $isMajor;


    /**
     * Set disorder
     *
     * @param integer $disorder
     * @return DisordersWays
     */
    public function setDisorder($disorder)
    {
        $this->disorder = $disorder;
    
        return $this;
    }

    /**
     * Get disorder
     *
     * @return integer 
     */
    public function getDisorder()
    {
        return $this->disorder;
    }

    /**
     * Set way
     *
     * @param integer $way
     * @return DisordersWays
     */
    public function setWay($way)
    {
        $this->way = $way;
    
        return $this;
    }

    /**
     * Get way
     *
     * @return integer 
     */
    public function getWay()
    {
        return $this->way;
    }

    /**
     * Set isMajor
     *
     * @param boolean $isMajor
     * @return DisordersWays
     */
    public function setIsMajor($isMajor)
    {
        $this->isMajor = $isMajor;
    
        return $this;
    }

    /**
     * Get isMajor
     *
     * @return boolean 
     */
    public function getIsMajor()
    {
        return $this->isMajor;
    }
}