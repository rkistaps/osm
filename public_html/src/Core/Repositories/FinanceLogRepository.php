<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\FinanceLogCollection;
use OSM\Core\Models\FinanceLog;

class FinanceLogRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'finance_logs';
    }

    protected function getModelClassName(): string
    {
        return FinanceLog::class;
    }

    protected function getCollectionClassName(): string
    {
        return FinanceLogCollection::class;
    }
}
