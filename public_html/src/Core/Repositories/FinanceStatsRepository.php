<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\FinanceStatsCollection;
use OSM\Core\Models\FinanceStats;

/**
 * @method FinanceStatsCollection findAll(array $condition = [])
 */
class FinanceStatsRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'finance_stats';
    }

    protected function getModelClassName(): string
    {
        return FinanceStats::class;
    }

    protected function getCollectionClassName(): string
    {
        return FinanceStatsCollection::class;
    }
}
