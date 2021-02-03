<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class PlayerName extends AbstractModel
{
    public const TYPE_NAME = 'name';
    public const TYPE_SURNAME = 'surname';

    public int $countryId;
    public string $type = self::TYPE_NAME;
    public string $value;
}
