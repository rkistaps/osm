<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Models\Player;

class PlayerRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'players';
    }

    protected function getModelClassName(): string
    {
        return Player::class;
    }

    protected function getCollectionClassName(): string
    {
        return PlayerCollection::class;
    }
}
