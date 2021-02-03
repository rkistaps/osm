<?php

declare(strict_types=1);

namespace OSM\Modules\Players\Creation\Structures;

use OSM\Core\Models\Team;

class SquadCreationParams
{
    public Team $team;
    public int $goalkeeperCount = 2;
    public int $defenderCount = 5;
    public int $midfielderCount = 5;
    public int $forwardCount = 4;
    public int $randomPlayerCount = 5;
}
