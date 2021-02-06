<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\Player;

/**
 * @method PlayerCollection filter(callable $callback = null)
 * @method Player firstWhere($key, $operator = null, $value = null)
 */
class PlayerCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return Player::class;
    }
}
