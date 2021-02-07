<?php

declare(strict_types=1);

namespace OSM\Modules\Series\Leagues\Services;

use OSM\Core\Models\Championship;

class LeagueLevelCreationService
{
    public function createNewLeagueLevel(Championship $championship)
    {
        if ($championship->type !== Championship::TYPE_LEAGUE) {
            throw new \InvalidArgumentException('Invalid championship type: ' . $championship->type);
        }
    }
}
