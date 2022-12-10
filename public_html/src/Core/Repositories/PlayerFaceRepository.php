<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\PlayerFaceCollection;
use OSM\Core\Models\Player;
use OSM\Core\Models\PlayerFace;

/**
 * @method PlayerFace createModel(array $properties = [], bool $persistent = false)
 * @method PlayerFace findOne(array $condition = [])
 */
class PlayerFaceRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'player_faces';
    }

    protected function getModelClassName(): string
    {
        return PlayerFace::class;
    }

    protected function getCollectionClassName(): string
    {
        return PlayerFaceCollection::class;
    }

    public function findForPlayer(Player $player): ?PlayerFace
    {
        return $this->findOne(['player_id' => $player->id]);
    }
}
