<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\ChampionshipCollection;
use OSM\Core\Models\AbstractModel;
use OSM\Core\Models\Championship;

/**
 * @method Championship saveModel(AbstractModel $model, array $properties = [])
 * @method Championship|null findById(int $id)
 * @method ChampionshipCollection findAll(array $condition = [])
 */
class ChampionshipRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'championships';
    }

    protected function getModelClassName(): string
    {
        return Championship::class;
    }

    protected function getCollectionClassName(): string
    {
        return ChampionshipCollection::class;
    }

    public function findByType(string $type): ChampionshipCollection
    {
        return $this->findAll(['type' => $type]);
    }
}
