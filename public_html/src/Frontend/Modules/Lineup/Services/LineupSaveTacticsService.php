<?php

declare(strict_types=1);

namespace OSM\Frontend\Modules\Lineup\Services;

use OSM\Core\Models\TeamLineup;
use OSM\Frontend\Modules\Lineup\Exceptions\TacticValidationException;

class LineupSaveTacticsService
{
    public function __construct()
    {

    }

    /**
     * @throws TacticValidationException
     */
    public function processSave(?string $tactic): bool
    {
        if (!$tactic || !isset(TeamLineup::getAvailableTactics()[$tactic])) {
            throw new TacticValidationException(_f('Invalid tactic'));
        }



        return true;
    }
}