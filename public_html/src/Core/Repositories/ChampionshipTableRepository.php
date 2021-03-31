<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\ChampionshipTableCollection;
use OSM\Core\Models\ChampionshipTable;

/**
 * @method ChampionshipTableCollection findAll(array $condition = [])
 */
class ChampionshipTableRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'championship_tables';
    }

    protected function getModelClassName(): string
    {
        return ChampionshipTable::class;
    }

    protected function getCollectionClassName(): string
    {
        return ChampionshipTableCollection::class;
    }

    public function deleteByChampionshipId(int $championshipId)
    {
        $this->deleteAll([
            'championship_id' => $championshipId,
        ]);
    }

    public function findByChampionshipId(int $championshipId): ChampionshipTableCollection
    {
        return $this->findAll([
            'championship_id' => $championshipId,
        ]);
    }
}
