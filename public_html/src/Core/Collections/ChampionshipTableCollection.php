<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\ChampionshipTable;

/**
 * @method ChampionshipTable[] all()
 */
class ChampionshipTableCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return ChampionshipTable::class;
    }

    public function getByTeamId(int $teamId): ?ChampionshipTable
    {
        return $this->first(fn(ChampionshipTable $table) => $table->teamId === $teamId);
    }
}
