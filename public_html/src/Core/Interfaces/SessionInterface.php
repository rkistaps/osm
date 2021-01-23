<?php

namespace OSM\Core\Interfaces;

interface SessionInterface
{
    public function set(string $key, $value);

    public function get(string $key, $default = null);

    public function setFlash(string $key, $value);

    public function getFlash(string $key, $default = null);

    public function clear(string $key);
}
