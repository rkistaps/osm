<?php

declare(strict_types=1);

namespace OSM\Core\Models;

class Country extends AbstractModel
{
    public string $name;
    public string $shortName;
    public string $skinTones;
}
