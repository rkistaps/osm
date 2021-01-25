<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class CountryModel extends Abs
{
    public ?int $id;
    public string $name;
    public string $shortName;
}
