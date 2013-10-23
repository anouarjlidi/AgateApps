<?php

namespace CorahnRin\CharactersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharAvtgs
 *
 * @ORM\Entity(repositoryClass="CorahnRin\CharactersBundle\Repository\DisordersWaysRepository")
 */
class DisordersWays
{
    /**
     * @var \Disorders
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Disorders", inversedBy="ways")
     */
    private $disorder;

    /**
     * @var \Ways
     *
     * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="\CorahnRin\CharactersBundle\Entity\Ways")
     */
    private $way;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=false)
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