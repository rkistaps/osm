<?php

namespace OSM\Modules\MatchEngine\Services;

use OSM\Modules\MatchEngine\Structures\Lineup;
use OSM\Modules\MatchEngine\Structures\Player;

/**
 * Class LineupValidatorService
 * @package OSM\Modules\MatchEngine\validators
 */
class LineupValidatorService
{
    public const MIN_REQUIRED_PLAYERS = 7;

    /**
     * @param Lineup $lineup
     * @return bool
     */
    public function validate(Lineup $lineup): bool
    {
        if (count($lineup->getStartingPlayers()) < self::MIN_REQUIRED_PLAYERS) {
            return false;
        }

        $goalkeeper = collect($lineup->players)->first(function (Player $player) {
            return $player->isGoalkeeper() && $player->isStarting();
        });

        if (!$goalkeeper) {
            return false;
        }

        return true;
    }
}
