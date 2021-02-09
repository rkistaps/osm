<?php

declare(strict_types=1);

namespace OSM\Core\Abstracts;

use Tightenco\Collect\Support\Collection;

abstract class AbstractCollection
{
    protected Collection $collection;

    public function __construct(array $data = [])
    {
        $this->collection = collect($data);
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }

    public function firstWhere($key, $operator = null, $value = null)
    {
        return $this->collection->firstWhere($key, $operator, $value);
    }

    public function first(callable $callback = null, $default = null)
    {
        return $this->collection->first($callback, $default);
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

    public function sort($callback = null)
    {
        return $this->collection->sort($callback);
    }

    public function pluck($value, $key = null)
    {
        return $this->collection->pluck($value, $key);
    }

    public function filter(callable $callback = null)
    {
        return $this->collection->filter($callback);
    }

    public function slice(int $offset, int $length = null)
    {
        return $this->collection->slice($offset, $length);
    }

    public function transform(callable $callable): AbstractCollection
    {
        $this->collection->transform($callable);

        return $this;
    }

    public function count(): int
    {
        return $this->collection->count();
    }

    public function merge(AbstractCollection $items)
    {
        $this->collection = $this->collection->merge($items->getCollection());

        return $this;
    }
}
