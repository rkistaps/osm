<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class FinanceStats extends AbstractModel
{
    public int $teamId;
    public string $event;
    public string $period;
    public float $amount;
}
