<?php

/**
 * This file is part of the corahn_rin package.
 *
 * (c) Alexandre Rock Ancelet <alex@orbitale.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CorahnRin\CorahnRinBundle\Entity;

use CorahnRin\CorahnRinBundle\Entity\Traits\HasBook;
use Doctrine\ORM\Mapping as ORM;

/**
 * Avantages.
 *
 * @ORM\Table(name="avantages")
 * @ORM\Entity(repositoryClass="CorahnRin\CorahnRinBundle\Repository\AvantagesRepository")
 */
class Avantages
{
    public const BONUS_100G  = '100g';
    public const BONUS_50G   = '50g';
    public const BONUS_20G   = '20g';
    public const BONUS_50A   = '50a';
    public const BONUS_20A   = '20a';
    public const BONUS_RESM  = 'resm';
    public const BONUS_BLESS = 'bless';
    public const BONUS_VIG   = 'vig';
    public const BONUS_TRAU  = 'trau';
    public const BONUS_DEF   = 'def';
    public const BONUS_RAP   = 'rap';
    public const BONUS_SUR   = 'sur';

    /**
     * Scholar advantage domain bonuses.
     * 4: Magience.
     * 7: Occultism.
     * 13: Science.
     * 16: Erudition.
     */
    public const BONUS_SCHOLAR_DOMAINS = [4, 7, 13, 16];

    use HasBook;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false, unique=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    protected $nameFemale;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint")
     */
    protected $xp;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var bool
     *
     * @ORM\Column(type="smallint")
     */
    protected $augmentation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    protected $bonusdisc;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isDesv;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    protected $isCombatArt;

    /**
     * @var int
     *
     * @ORM\Column(name="avtg_group", type="smallint", options={"default"="0"}, nullable=true)
     */
    protected $group = 0;

    /**
     * Get id.
     *
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
     * @return $this
     *
     * @codeCoverageIgnore
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Avantages
     *
     * @codeCoverageIgnore
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameFemale.
     *
     * @param string $nameFemale
     *
     * @return Avantages
     *
     * @codeCoverageIgnore
     */
    public function setNameFemale($nameFemale)
    {
        $this->nameFemale = $nameFemale;

        return $this;
    }

    /**
     * Get nameFemale.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getNameFemale()
    {
        return $this->nameFemale;
    }

    /**
     * Set xp.
     *
     * @param int $xp
     *
     * @return Avantages
     *
     * @codeCoverageIgnore
     */
    public function setXp($xp)
    {
        $this->xp = $xp;

        return $this;
    }

    /**
     * Get xp.
     *
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Avantages
     *
     * @codeCoverageIgnore
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set bonusdisc.
     *
     * @param string $bonusdisc
     *
     * @return Avantages
     *
     * @codeCoverageIgnore
     */
    public function setBonusdisc($bonusdisc)
    {
        $this->bonusdisc = $bonusdisc;

        return $this;
    }

    /**
     * Get bonusdisc.
     *
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getBonusdisc()
    {
        return $this->bonusdisc;
    }

    /**
     * Set isDesv.
     *
     * @param bool $isDesv
     *
     * @return Avantages
     *
     * @codeCoverageIgnore
     */
    public function setDesv($isDesv)
    {
        $this->isDesv = $isDesv;

        return $this;
    }

    /**
     * Get isDesv.
     *
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function isDesv()
    {
        return $this->isDesv;
    }

    /**
     * Set isCombatArt.
     *
     * @param bool $isCombatArt
     *
     * @return Avantages
     *
     * @codeCoverageIgnore
     */
    public function setCombatArt($isCombatArt)
    {
        $this->isCombatArt = $isCombatArt;

        return $this;
    }

    /**
     * Get isCombatArt.
     *
     * @return bool
     *
     * @codeCoverageIgnore
     */
    public function isCombatArt()
    {
        return $this->isCombatArt;
    }

    /**
     * Set augmentation.
     *
     * @param int $augmentation
     *
     * @return Avantages
     *
     * @codeCoverageIgnore
     */
    public function setAugmentation($augmentation)
    {
        $this->augmentation = $augmentation;

        return $this;
    }

    /**
     * Get augmentation.
     *
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getAugmentation()
    {
        return $this->augmentation;
    }

    /**
     * Set group.
     *
     * @param int $group
     *
     * @return Avantages
     *
     * @codeCoverageIgnore
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group.
     *
     * @return int
     *
     * @codeCoverageIgnore
     */
    public function getGroup()
    {
        return $this->group;
    }
}
