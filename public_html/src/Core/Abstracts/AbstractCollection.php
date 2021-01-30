<?php

declare(strict_types=1);

namespace OSM\Core\Abstracts;

use Tightenco\Collect\Support\Collection;

class AbstractCollection
{
    protected Collection $collection;

    public function __construct(array $data = [])
    {
        $this->collection = collect($data);
    }
}
