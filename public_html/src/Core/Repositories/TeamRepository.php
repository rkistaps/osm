<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\TeamCollection;
use OSM\Core\Models\AbstractModel;
use OSM\Core\Models\Team;

/**
 * @method Team createModel(array $properties = [], bool $persistent = false)
 * @method Team saveModel(AbstractModel $model, array $properties = [])
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
}
