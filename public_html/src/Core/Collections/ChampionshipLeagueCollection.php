<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\ChampionshipLeague;

class ChampionshipLeagueCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return ChampionshipLeague::class;
    }
}
