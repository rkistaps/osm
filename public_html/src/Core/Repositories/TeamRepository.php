<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\TeamCollection;
use OSM\Core\Models\AbstractModel;
use OSM\Core\Models\Team;

/**
 * @method Team createModel(array $properties = [], bool $persistent = false)
 * @method Team saveModel(AbstractModel $model, array $properties = [])
 * @method Team|null findOne(array $condition = [])
 * @method Team|null findById(int $id)
 * @method TeamCollection findAll(array $condition = [])
 */
class TeamRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'teams';
    }

    protected function getModelClassName(): string
    {
        return Team::class;
    }

    protected function getCollectionClassName(): string
    {
        return TeamCollection::class;
    }

    public function findByName(string $name): ?Team
    {
        return $this->findOne(['name' => $name]);
    }

    public function findTeamsWithoutChampionship(int $countryId = null, int $limit = 10): TeamCollection
    {
        $cond = ['championship_id' => null];
        if ($countryId) {
            $cond['country_id'] = $countryId;
        }

        $models = $this
            ->buildQuery($cond)
            ->limit($limit)
            ->select()
            ->fetchClass($this->getModelClassName())
            ->all();

        return new TeamCollection($models);
    }

    public function findByIds(array $ids): TeamCollection
    {
        return $this->findAll(['id' => $ids]);
    }
}
