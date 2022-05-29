<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\TeamLineupPlayerCollection;
use OSM\Core\Models\TeamLineupPlayer;

/**
 * @method TeamLineupPlayerCollection findAll(array $condition = [])
 */
class TeamLineupPlayerRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'team_lineup_players';
    }

    protected function getModelClassName(): string
    {
        return TeamLineupPlayer::class;
    }

    protected function getCollectionClassName(): string
    {
        return TeamLineupPlayerCollection::class;
    }

    public function findByLineupId(int $lineupId): TeamLineupPlayerCollection
    {
        return $this->findAll([
            'team_lineup_id' => $lineupId,
        ]);
    }

    public function removePlayerIdsFromLineup(array $playerIds, int $lineupId): int
    {
        return $this->deleteAll([
            'team_lineup_id' => $lineupId,
            'player_id' => $playerIds,
        ]);
    }
}
