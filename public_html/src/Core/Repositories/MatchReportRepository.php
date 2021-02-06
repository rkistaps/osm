<?php

declare(strict_types=1);

namespace OSM\Core\Repositories;

use OSM\Core\Collections\MatchReportCollection;
use OSM\Core\Models\MatchReport;

class MatchReportRepository extends AbstractModelRepository
{
    protected function getTableName(): string
    {
        return 'match_reports';
    }

    protected function getModelClassName(): string
    {
        return MatchReport::class;
    }

    protected function getCollectionClassName(): string
    {
        return MatchReportCollection::class;
    }
}
