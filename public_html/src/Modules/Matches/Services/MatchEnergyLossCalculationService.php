<?php

declare(strict_types=1);

namespace OSM\Modules\Matches\Services;

use OSM\Core\Helpers\NumberHelper;
use OSM\Core\Models\Player as PlayerModel;
use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\Player;

class MatchEnergyLossCalculationService
{
    public function calculateEnergyLoss(Player $player, string $pressure): int
    {
        if ($player->isGoalkeeper()) {
            return rand(2, 4);
        }

        // starting energy loss
        $energyLoss = rand(8, 9);

        // pressure modifiers
        switch ($pressure) {
            case Lineup::PRESSURE_HARD:
                $energyLoss += 6;
                break;
            case Lineup::PRESSURE_SOFT:
                $energyLoss -= 4;
                break;
            default: // Lineup::PRESSURE_NORMAL
                $energyLoss += 0;
        }

        // age modifiers
        if (NumberHelper::isSmaller($player->age, 20)) {
            $energyLoss -= 2;
        } elseif (NumberHelper::isBetween($player->age, 21, 23)) {
            $energyLoss -= 1;
        } elseif (NumberHelper::isBetween($player->age, 28, 29)) {
            $energyLoss += 1;
        } elseif (NumberHelper::isBigger($player->age, 30)) {
            $energyLoss += 2;
        }

        // speciality modifiers
        if ($player->speciality === PlayerModel::SPECIALITY_WEAK) {
            $energyLoss += 2;
        } elseif ($player->speciality === PlayerModel::SPECIALITY_IRONMAN) {
            $energyLoss -= 3;
        }

        return $energyLoss;
    }
}
