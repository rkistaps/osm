<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\TeamLineup;

class TeamLineupCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return TeamLineup::class;
    }


}
