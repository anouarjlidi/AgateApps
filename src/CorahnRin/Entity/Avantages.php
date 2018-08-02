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

use CorahnRin\Data\Domains;
use CorahnRin\Entity\Traits\HasBook;
use Doctrine\ORM\Mapping as ORM;

/**
 * Avantages.
 *
 * @ORM\Table(name="avantages")
 * @ORM\Entity(repositoryClass="CorahnRin\Repository\AvantagesRepository")
 */
class Avantages
{
    public const BONUS_100G = '100g';
    public const BONUS_50G = '50g';
    public const BONUS_20G = '20g';
    public const BONUS_10G = '10g';
    public const BONUS_50A = '50a';
    public const BONUS_20A = '20a';
    public const BONUS_RESM = 'resm';
    public const BONUS_BLESS = 'bless';
    public const BONUS_VIG = 'vig';
    public const BONUS_TRAU = 'trau';
    public const BONUS_DEF = 'def';
    public const BONUS_RAP = 'rap';
    public const BONUS_SUR = 'sur';

    public const POSSIBLE_BONUSES = [
        self::BONUS_100G,
        self::BONUS_50G,
        self::BONUS_20G,
        self::BONUS_10G,
        self::BONUS_50A,
        self::BONUS_20A,
        self::BONUS_RESM,
        self::BONUS_BLESS,
        self::BONUS_VIG,
        self::BONUS_TRAU,
        self::BONUS_DEF,
        self::BONUS_RAP,
        self::BONUS_SUR,
        Domains::CRAFT['title'],
        Domains::CLOSE_COMBAT['title'],
        Domains::STEALTH['title'],
        Domains::MAGIENCE['title'],
        Domains::NATURAL_ENVIRONMENT['title'],
        Domains::DEMORTHEN_MYSTERIES['title'],
        Domains::OCCULTISM['title'],
        Domains::PERCEPTION['title'],
        Domains::PRAYER['title'],
        Domains::FEATS['title'],
        Domains::RELATION['title'],
        Domains::PERFORMANCE['title'],
        Domains::SCIENCE['title'],
        Domains::SHOOTING_AND_THROWING['title'],
        Domains::TRAVEL['title'],
        Domains::ERUDITION['title'],
    ];

    /**
     * Scholar advantage domain bonuses.
     * 4: Magience.
     * 7: Occultism.
     * 13: Science.
     * 16: Erudition.
     */
    public const BONUS_SCHOLAR_DOMAINS = [Domains::MAGIENCE['title'], Domains::OCCULTISM['title'], Domains::SCIENCE['title'], Domains::ERUDITION['title']];

    use HasBook;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\Id
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
     * @var string[]
     *
     * @ORM\Column(name="bonuses_for", type="simple_array", options={"default"=""})
     */
    protected $bonusesFor;

    /**
     * If true, $bonusesFor will be applied to ALL bonuses.
     * Else, it will be for ONE of them, and the user has to choose
     *
     * @var bool
     *
     * @ORM\Column(name="bonuses_for_all", type="boolean", options={"default"="1"})
     */
    private $bonusesForAll = true;

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
     * @ORM\Column(name="avtg_group", type="smallint", options={"default" = "0"}, nullable=true)
     */
    protected $group = 0;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
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
     */
    public function getDescription()
    {
        return $this->description;
    }

    public function isBonusesForAll(): bool
    {
        return $this->bonusesForAll;
    }

    public function setBonusesForAll(bool $bonusesForAll): void
    {
        $this->bonusesForAll = $bonusesForAll;
    }

    public function setBonusesFor(array $bonusesFor): void
    {
        foreach ($bonusesFor as $bonusFor) {
            $this->addBonusFor($bonusFor);
        }
    }

    public function addBonusFor(string $bonusFor): void
    {
        if (!\in_array($bonusFor, self::POSSIBLE_BONUSES, true)) {
            throw new \InvalidArgumentException(sprintf('Invalid bonus name "%s". Possible values are: %s', $bonusFor, implode(', ', self::POSSIBLE_BONUSES)));
        }

        $this->bonusesFor[] = $bonusFor;

        $this->bonusesFor = \array_unique($this->bonusesFor);
    }

    public function getBonusesFor(): array
    {
        return $this->bonusesFor;
    }

    /**
     * Set isDesv.
     *
     * @param bool $isDesv
     *
     * @return Avantages
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
     */
    public function getGroup()
    {
        return $this->group;
    }
}
