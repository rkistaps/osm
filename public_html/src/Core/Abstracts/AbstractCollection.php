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

    public function firstWhere(string $key, $operator = null, $value = null)
    {
        return $this->collection->firstWhere($key, $operator, $value);
    }

    public function where($key, $operator = null, $value = null)
    {
        return $this->collection->where($key, $operator, $value);
    }

    public function random($number = null)
    {
        if (!$this->collection->count()) {
            return null;
        }

        return $this->collection->random($number);
    }
}
