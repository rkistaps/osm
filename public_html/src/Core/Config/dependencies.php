<?php

use AutoMapperPlus\AutoMapper;
use League\Plates\Engine;
use Opis\Database\Database;
use OSM\Core\Factories\AutomapperFactory;
use OSM\Core\Factories\DatabaseFactory;
use OSM\Core\Factories\TemplateEngineFactory;
use OSM\Core\Interfaces\ModelDataHydratorInterface;
use OSM\Core\Interfaces\SessionInterface;
use OSM\Core\Services\ModelDataHydratorService;
use OSM\Frontend\Services\SessionService;
use Psr\Container\ContainerInterface;
use TheApp\Components\CommandRunner;
use TheApp\Factories\CommandRunnerFactory;
use TheApp\Factories\ConfigFactory;
use TheApp\Factories\RouterFactory;
use TheApp\Interfaces\ConfigInterface;
use TheApp\Interfaces\RouterInterface;

return [
    ConfigInterface::class => fn(ConfigFactory $configFactory) => $configFactory->fromArray(require APP_ROOT . '/src/Core/Config/config.php'),
    RouterInterface::class => fn(RouterFactory $routerFactory, ConfigInterface $config) => $routerFactory->buildFromConfig($config),
    CommandRunner::class => fn(CommandRunnerFactory $commandRunnerFactory, ConfigInterface $config) => $commandRunnerFactory->fromConfig($config),
    Engine::class => fn(TemplateEngineFactory $factory, ConfigInterface $config) => $factory->fromConfig($config),
    SessionInterface::class => fn(ContainerInterface $container) => $container->get(SessionService::class),
    Database::class => fn(DatabaseFactory $factory, ConfigInterface $config) => $factory->fromConfig($config),
    AutoMapper::class => fn(ConfigInterface $config, AutoMapperFactory $autoMapperFactory) => $autoMapperFactory->fromConfig($config),
    ModelDataHydratorInterface::class => fn(ContainerInterface $container) => $container->get(ModelDataHydratorService::class),
];
