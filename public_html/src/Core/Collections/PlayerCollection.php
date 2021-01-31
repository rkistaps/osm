<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Player;

class PlayerCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Player::class;
    }
}
