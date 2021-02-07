<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Championship;

class ChampionshipCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Championship::class;
    }
}
