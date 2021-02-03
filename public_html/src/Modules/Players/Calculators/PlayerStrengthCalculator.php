<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Calculators;

use OSM\Core\Models\Player;

class PlayerStrengthCalculator
{
    public const EXP_BONUS_MODIFIER = 2000;

    public function calculateStrength(Player $player)
    {
        return $player->skill * (100 - (100 - $player->energy)) * (1 + $player->experience / self::EXP_BONUS_MODIFIER);
    }
}
