<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class TeamLineupPlayer extends AbstractModel
{
    public int $playerId;
    public int $teamLineupId;
}
