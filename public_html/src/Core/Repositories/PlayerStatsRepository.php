<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\PlayerStatsCollection;
use OSM\Core\Models\PlayerStats;

/**
 * @method PlayerStatsCollection findAll(array $condition = [])
 */
class PlayerStatsRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'player_stats';
    }

    protected function getModelClassName(): string
    {
        return PlayerStats::class;
    }

    protected function getCollectionClassName(): string
    {
        return PlayerStatsCollection::class;
    }
}
