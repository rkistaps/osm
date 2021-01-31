<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Team extends AbstractModel
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_DELETED = 'deleted';

    public const TRAINING_PRIORITY_G = 'G';
    public const TRAINING_PRIORITY_D = 'D';
    public const TRAINING_PRIORITY_M = 'M';
    public const TRAINING_PRIORITY_F = 'F';

    public string $name;
    public int $userId;
    public float $money = 0;
    public int $countryId;
    public int $supporters = 0;
    public int $stadiumSize = 0;
    public int $rating = 0;
    public string $trainingPriority = self::TRAINING_PRIORITY_M;
    public string $status = self::STATUS_ACTIVE;
    public bool $isDefault = true;

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}
