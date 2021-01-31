<?php

declare(strict_types=1);

namespace OSM\Modules\Options\Structures;

use OSM\Core\Helpers\Traits\FromArrayTrait;

class OptionDefinition
{
    use  FromArrayTrait;

    public string $label;
    public string $name;
    public string $defaultValue;
}
