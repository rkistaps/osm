<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Team;

class TeamCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Team::class;
    }
}
