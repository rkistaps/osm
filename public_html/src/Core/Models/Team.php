<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Team extends AbstractModel
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public string $name;
    public int $userId;
    public float $money;
    public int $countryId;
    public int $supporters;
    public int $stadiumSize;
    public int $rating;
    public string $trainingPriority;
    public string $status;
    public bool $isDefault;

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
