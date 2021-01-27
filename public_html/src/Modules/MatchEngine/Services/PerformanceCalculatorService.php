<?php

namespace OSM\Modules\MatchEngine\Services;

use OSM\Modules\MatchEngine\Helpers\MatchHelper;
use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\MatchSettings;
use OSM\Modules\MatchEngine\Structures\Player;
use OSM\Modules\MatchEngine\Structures\PlayerPerformance;

/**
 * Class PerformanceCalculatorService
 * @package OSM\Modules\MatchEngine\calculators
 */
class PerformanceCalculatorService
{
    /**
     * Calculate performance for a lineup
     * @param Lineup $lineup
     * @param MatchSettings $settings
     */
    public function calculateForLineup(Lineup $lineup, MatchSettings $settings)
    {
        foreach ($lineup->players as $player) {
            $player->performance = $this->calculateForPlayer($player, $settings);
            if ($player->isStarting()) {
                $player->performance->playedToMin = MatchHelper::MATCH_LENGTH;
            }
        }
    }

    /**
     * Calculate performance for a player
     * @param Player $player
     * @param MatchSettings $settings
     * @return PlayerPerformance
     */
    public function calculateForPlayer(Player $player, MatchSettings $settings): PlayerPerformance
    {
        $performanceK = rand(100 - $settings->performanceRandomRange, 100 + $settings->performanceRandomRange) / 100;
        $experienceK = 1 + $player->experience / 2000;
        $energyK = $player->energy / 100;

        $performance = new PlayerPerformance();
        $performance->performance = floor($player->skill * $performanceK * $experienceK * $energyK);
        $performance->performanceK = $performanceK;

        return $performance;
    }
}
