<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class ContainerFactory
{
    public static function build(): ContainerInterface
    {
        return (new ContainerBuilder())
            ->addDefinitions(require APP_ROOT . '/src/Core/Config/dependencies.php')
            ->build();
    }
}
