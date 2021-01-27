<?php

namespace OSM\Modules\MatchEngine\Structures;

use OSM\Modules\MatchEngine\Helpers\MatchHelper;

/**
 * This structure describes players performance in a match
 */
class PlayerPerformance
{
    public int $playedFromMin = 0;
    public int $playedToMin = 0;
    public int $performanceK = 1;
    public int $performance = 0;

    /**
     * Calculate players impact on game
     * @return int
     */
    public function getImpact(): int
    {
        return round($this->performance * $this->getParticipation());
    }

    /**
     * @return float|int
     */
    public function getParticipation()
    {
        return ($this->playedToMin - $this->playedFromMin) / MatchHelper::MATCH_LENGTH;
    }
}
