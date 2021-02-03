<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\TeamLineupPlayer;

class TeamLineupPlayerCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return TeamLineupPlayer::class;
    }
}
