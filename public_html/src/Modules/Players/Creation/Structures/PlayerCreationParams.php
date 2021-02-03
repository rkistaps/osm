<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Creation\Structures;

use OSM\Core\Models\Country;
use OSM\Core\Models\Player;
use OSM\Core\Models\Team;

class PlayerCreationParams
{
    public Team $team;
    public Country $country;

    public ?string $position = null;
    public int $age = 0;
    public float $skill = 0;
    public int $talent = 0;
    public bool $isYouth = false;
    public string $character = Player::CHARACTER_NONE;
    public string $speciality = Player::SPECIALITY_NONE;
    public bool $canHaveFacialHair = false;
}
