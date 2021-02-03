<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\PlayerName;

class PlayerNameCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return PlayerName::class;
    }
}
