<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Models\AbstractModel;
use OSM\Core\Models\Player;

/**
 * @method Player createModel(array $properties = [], bool $persistent = false)
 * @method Player saveModel(AbstractModel $model, array $properties = [])
 * @method PlayerCollection findAll(array $condition = [])
 */
class PlayerRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'players';
    }

    protected function getModelClassName(): string
    {
        return Player::class;
    }

    protected function getCollectionClassName(): string
    {
        return PlayerCollection::class;
    }

    public function getSquadPlayersByTeam(int $teamId): PlayerCollection
    {
        return $this->findAll([
            'team_id' => $teamId,
            'is_youth' => false,
        ]);
    }

    public function getPlayersForTeamLineupId(int $teamLineupId): PlayerCollection
    {
        $rows = $this->database
            ->from($this->getTableName())
            ->join('team_lineup_players', function ($join) {
                $join->on('players.id', 'team_lineup_players.player_id');
            })
            ->select('players.*')
            ->fetchClass($this->getModelClassName())
            ->all();

        return new PlayerCollection($rows);
    }
}
