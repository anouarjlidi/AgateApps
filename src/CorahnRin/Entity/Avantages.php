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

use CorahnRin\Data\DomainsData;
use CorahnRin\Entity\CharacterProperties\Bonuses;
use CorahnRin\Entity\Traits\HasBook;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="avantages")
 * @ORM\Entity(repositoryClass="CorahnRin\Repository\AvantagesRepository")
 */
class Avantages
{
    public const INDICATION_TYPE_SINGLE_VALUE = 'single_value';
    public const INDICATION_TYPE_SINGLE_CHOICE = 'single_choice';

    public const INDICATION_TYPES = [
        self::INDICATION_TYPE_SINGLE_VALUE,
        self::INDICATION_TYPE_SINGLE_CHOICE,
    ];

    public const POSSIBLE_BONUSES = [
        Bonuses::MONEY_100G,
        Bonuses::MONEY_50G,
        Bonuses::MONEY_20G,
        Bonuses::MONEY_10G,
        Bonuses::MONEY_50A,
        Bonuses::MONEY_20A,
        Bonuses::LUCK,
        Bonuses::MENTAL_RESISTANCE,
        Bonuses::HEALTH,
        Bonuses::STAMINA,
        Bonuses::TRAUMA,
        Bonuses::DEFENSE,
        Bonuses::SPEED,
        Bonuses::SURVIVAL,
        DomainsData::CRAFT['title'],
        DomainsData::CLOSE_COMBAT['title'],
        DomainsData::STEALTH['title'],
        DomainsData::MAGIENCE['title'],
        DomainsData::NATURAL_ENVIRONMENT['title'],
        DomainsData::DEMORTHEN_MYSTERIES['title'],
        DomainsData::OCCULTISM['title'],
        DomainsData::PERCEPTION['title'],
        DomainsData::PRAYER['title'],
        DomainsData::FEATS['title'],
        DomainsData::RELATION['title'],
        DomainsData::PERFORMANCE['title'],
        DomainsData::SCIENCE['title'],
        DomainsData::SHOOTING_AND_THROWING['title'],
        DomainsData::TRAVEL['title'],
        DomainsData::ERUDITION['title'],
    ];

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
     * @var int
     *
     * @ORM\Column(name="augmentation_count", type="smallint", nullable=false)
     */
    protected $augmentationCount;

    /**
     * @var string[]
     *
     * @ORM\Column(name="bonuses_for", type="simple_array", options={"default" = ""}, nullable=true)
     */
    protected $bonusesFor;

    /**
     * @var string
     *
     * @ORM\Column(name="requires_indication", type="string", nullable=true)
     */
    protected $requiresIndication;

    /**
     * If type is "choice", the list will be fetched from self::$bonusesFor.
     *
     * @var string
     *
     * @ORM\Column(name="indication_type", type="string", length=20, nullable=false, options={"default" = "single_value"})
     */
    protected $indicationType = self::INDICATION_TYPE_SINGLE_VALUE;

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
     * @var string
     *
     * @ORM\Column(name="avtg_group", type="string", nullable=true)
     */
    protected $group = '';

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

    public function setBonusesFor(array $bonusesFor): void
    {
        foreach ($bonusesFor as $bonusFor) {
            $this->addBonusFor($bonusFor);
        }
    }

    public function addBonusFor(string $bonusFor): void
    {
        if (!\in_array($bonusFor, self::POSSIBLE_BONUSES, true)) {
            throw new \InvalidArgumentException(\sprintf('Invalid bonus name "%s". Possible values are: %s', $bonusFor, \implode(', ', self::POSSIBLE_BONUSES)));
        }

        $this->bonusesFor[] = $bonusFor;

        $this->bonusesFor = \array_unique($this->bonusesFor);
    }

    public function getBonusesFor(): array
    {
        return $this->bonusesFor;
    }

    public function getRequiresIndication(): ?string
    {
        return $this->requiresIndication;
    }

    public function setRequiresIndication(?string $requiresIndication): void
    {
        $this->requiresIndication = $requiresIndication;
    }

    public function getIndicationType(): string
    {
        return $this->indicationType;
    }

    public function setIndicationType(string $indicationType): void
    {
        if (!\in_array($indicationType, self::INDICATION_TYPES, true)) {
            throw new \InvalidArgumentException(\sprintf('Invalid indication type "%s". Possible values are: %s', $indicationType, \implode(', ', self::INDICATION_TYPES)));
        }

        $this->indicationType = $indicationType;
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

    public function setAugmentationCount(int $augmentationCount): self
    {
        $this->augmentationCount = $augmentationCount;

        return $this;
    }

    public function getAugmentationCount(): int
    {
        return $this->augmentationCount;
    }

    public function setGroup(?string $group): self
    {
        $this->group = (string) $group;

        return $this;
    }

    public function getGroup(): string
    {
        return (string) $this->group;
    }
}
