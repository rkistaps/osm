<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Country extends AbstractModel
{
    public ?int $id;
    public string $name;
    public string $shortName;
}
