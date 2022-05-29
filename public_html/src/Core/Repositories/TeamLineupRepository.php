<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\TeamLineupCollection;
use OSM\Core\Models\TeamLineup;

/**
 * @method TeamLineup|null findOne(array $condition = [])
 * @method TeamLineup|null findById(int $id)
 */
class TeamLineupRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'team_lineups';
    }

    protected function getModelClassName(): string
    {
        return TeamLineup::class;
    }

    protected function getCollectionClassName(): string
    {
        return TeamLineupCollection::class;
    }

    public function removeDefaultLineupForTeam(int $teamId)
    {
        $this->updateAll(['is_default' => false], ['team_id' => $teamId]);
    }

    public function getDefaultForTeamId(int $teamId): ?TeamLineup
    {
        return $this->findOne([
            'team_id' => $teamId,
            'is_default' => true,
        ]);
    }
}
