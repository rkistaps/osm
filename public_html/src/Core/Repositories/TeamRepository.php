<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\TeamCollection;
use OSM\Core\Models\Team;

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
