<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class FinanceLog extends AbstractModel
{
    public const EVENT_STARTING_MONEY = 'starting-money';

    public int $teamId;
    public string $event;
    public float $change;
    public float $result;
    public string $date;
}