<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\MatchCollection;
use OSM\Core\Models\Match;

class MatchRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'matches';
    }

    protected function getModelClassName(): string
    {
        return Match::class;
    }

    protected function getCollectionClassName(): string
    {
        return MatchCollection::class;
    }
}
