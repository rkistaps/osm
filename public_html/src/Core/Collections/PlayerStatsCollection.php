<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\PlayerStats;

class PlayerStatsCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return PlayerStats::class;
    }
}
