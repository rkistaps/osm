<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use DI\Container;

class GenericFactory
{
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get(string $className)
    {
        return $this->container->get($className);
    }
}
