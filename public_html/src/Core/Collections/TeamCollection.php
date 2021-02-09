<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Team;

/**
 * @method Team[] all()
 */
class TeamCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Team::class;
    }
}
