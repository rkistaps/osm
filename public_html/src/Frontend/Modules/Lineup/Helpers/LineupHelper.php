<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Helpers;

use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Models\Player;

class LineupHelper
{
    public static function sortPlayerCollection(PlayerCollection $players): PlayerCollection
    {
        return $players->sort(function (Player $playerA, Player $playerB) {
            $weightA = self::calculatePlayerSortWeight($playerA);
            $weightB = self::calculatePlayerSortWeight($playerB);

            return $weightA < $weightB ? 1 : 0;
        });
    }

    public static function calculatePlayerSortWeight(Player $player): float
    {
        $weight = 0;
        $weight = $player->isGoalkeeper() ? 10000 : $weight;
        $weight = $player->isDefender() ? 1000 : $weight;
        $weight = $player->isMidfielder() ? 100 : $weight;
        $weight = $player->isForward() ? 10 : $weight;

        $weight += $player->skill / 1000;

        return $weight;
    }
}
