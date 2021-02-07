<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Championship extends AbstractModel
{
    public const TYPE_LEAGUE = 'league';

    public string $name;
    public string $type;
}
