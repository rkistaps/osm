<?php

declare(strict_types=1);

namespace OSM\Core\Components;

class ArrayCache
{
    private array $cache = [];

    public function set(string $key, $value)
    {
        $this->cache[$key] = $value;
    }

    public function get(string $key, $default = null)
    {
        return $this->cache[$key] ?? $default;
    }

    public function clear(string $key)
    {
        if (!$this->has($key)) {
            return;
        }

        unset($this->cache[$key]);
    }

    public function has(string $key): bool
    {
        return !is_null($this->cache[$key] ?? null);
    }

    public function getOrSet(string $key, callable $callable)
    {
        if (!$this->has($key)) {
            $this->set($key, $callable());
        }

        return $this->get($key);
    }
}
