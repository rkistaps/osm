<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\FinanceStats;

class FinanceStatsCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return FinanceStats::class;
    }
}
