<?php

declare(strict_types=1);

namespace OSM\Core\Collections;

use OSM\Core\Models\FinanceLog;

class FinanceLogCollection extends AbstractModelCollection
{
    public function getModelClassName(): string
    {
        return FinanceLog::class;
    }
}
