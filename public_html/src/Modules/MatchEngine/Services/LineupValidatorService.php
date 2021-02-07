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
    /**
     * @param Lineup $lineup
     * @return bool
     */
    public function validate(Lineup $lineup): bool
    {
        if (count($lineup->getStartingPlayers()) < 7) {
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
