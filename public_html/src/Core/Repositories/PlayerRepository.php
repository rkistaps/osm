<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\PlayerCollection;
use OSM\Core\Models\AbstractModel;
use OSM\Core\Models\Player;

/**
 * @method Player createModel(array $properties = [], bool $persistent = false)
 * @method Player saveModel(AbstractModel $model, array $properties = [])
 */
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
