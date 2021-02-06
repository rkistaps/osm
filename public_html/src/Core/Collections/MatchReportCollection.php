<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\MatchReport;

class MatchReportCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return MatchReport::class;
    }
}
