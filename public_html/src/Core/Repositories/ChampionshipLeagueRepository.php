<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\ChampionshipLeagueCollection;
use OSM\Core\Models\ChampionshipLeague;

class ChampionshipLeagueRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'championship_leagues';
    }

    protected function getModelClassName(): string
    {
        return ChampionshipLeague::class;
    }

    protected function getCollectionClassName(): string
    {
        return ChampionshipLeagueCollection::class;
    }
}
