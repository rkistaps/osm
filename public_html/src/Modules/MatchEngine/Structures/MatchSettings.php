<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class MatchSettings
 * @package OSM\Modules\MatchEngine\Structures
 */
class MatchSettings
{
    public float $homeTeamBonus = 1.15;
    public bool $hasHomeTeamBonus = true;
    public float $coachSpecialityBonus = 1.15;
    public float $coachLevelBonus = 1.05;

    public float $defenseModifier = 3.5;
    public float $midfieldModifier = 3.5;
    public float $attackModifier = 2.5;

    public int $performanceRandomRange = 10;
    public int $possessionRandomRange = 10;
    public int $baseAttackCount = 10;
    public int $attackCountRandomModifier = 10;
    public int $injuryChances = 5;
    public int $injuryPercentage = 1;
    public int $yellowCardChances = 5;
    public int $yellowCardPercentage = 10;
    public int $redCardChances = 3;
    public int $redCardPercentage = 3;
    public bool $withPressure = true;
    public bool $allowDraw = true;
}
