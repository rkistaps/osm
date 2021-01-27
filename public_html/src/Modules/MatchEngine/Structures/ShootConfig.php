<?php

namespace OSM\Modules\MatchEngine\Structures;

/**
 * Class ShootConfig
 * @package OSM\Modules\MatchEngine\Structures
 */
class ShootConfig
{
    public int $minute = 0;
    public int $attackingTeamId;
    public int $defendingTeamId;
    public Player $striker;
    public Player $goalkeeper;
    public ?Player $attackHelper;
    public ?Player $defenseHelper;
    public int $saveBonus = 0;
    public int $randomModifier = 7;
}
