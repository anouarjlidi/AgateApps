<?php

namespace CorahnRin\Data\Character;

class DomainScore
{
    private $wayValue;

    private $base;

    private $bonus;

    private $malus;

    public function __construct(
        int $wayValue,
        int $base,
        int $bonus,
        int $malus
    ) {
        $this->wayValue = $wayValue;
        $this->base = $base;
        $this->bonus = $bonus;
        $this->malus = $malus;
    }

    public function getWayValue(): string
    {
        return $this->wayValue;
    }

    public function getBase(): int
    {
        return $this->base;
    }

    public function getBonus(): int
    {
        return $this->bonus;
    }

    public function getMalus(): int
    {
        return $this->malus;
    }

    public function getTotal(): int
    {
        return static::getTotalForValues($this->wayValue, $this->base, $this->bonus, $this->malus);
    }

    private static function getTotalForValues(
        int $wayValue,
        int $base,
        int $bonus,
        int $malus
    ): int {
        return $wayValue + $base + $bonus - $malus;
    }
}
