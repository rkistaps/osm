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

    public function getByTypeAndPlayerId(string $type, int $playerId): ?PlayerStats
    {
        return $this->collection->first(
            fn(PlayerStats $playerStats) => $type === $playerStats->type && $playerId === $playerStats->playerId
        );
    }
}
