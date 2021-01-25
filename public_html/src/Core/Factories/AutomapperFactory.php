<?php

declare(strict_types=1);

namespace OSM\Core\Factories;

use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\Configuration\AutoMapperConfig;
use AutoMapperPlus\Configuration\AutoMapperConfigInterface;
use Psr\Container\ContainerInterface;
use TheApp\Interfaces\ConfigInterface;

class AutomapperFactory
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function fromConfig(ConfigInterface $config): AutoMapper
    {
        $automapperConfig = new AutoMapperConfig();

        foreach ($config->get('automapper.configs', []) as $configuratorClass) {
            $configurator = $this->container->get($configuratorClass);
            if (is_a($configurator, AutoMapperConfigInterface::class)) {
                $configurator->configure($automapperConfig);
            }
        }

        return new AutoMapper($automapperConfig);
    }
}
