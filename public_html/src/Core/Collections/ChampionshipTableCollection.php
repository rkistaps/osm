<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\ChampionshipTable;

class ChampionshipTableCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return ChampionshipTable::class;
    }
}
