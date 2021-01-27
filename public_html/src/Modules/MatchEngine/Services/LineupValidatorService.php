<?php

namespace OSM\Modules\MatchEngine\Services;

use OSM\Modules\MatchEngine\Helpers\LineupHelper;
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

        $goalkeeper = LineupHelper::getRandomPlayerInPosition($lineup, Player::POS_G, 1);
        if (!$goalkeeper) {
            return false;
        }

        return true;
    }
}
