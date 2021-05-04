<?php

use AutoMapperPlus\AutoMapper;
use League\Flysystem\Filesystem;
use League\Plates\Engine;
use Opis\Database\Database;
use OSM\Core\AppTypes;
use OSM\Core\Components\ConsoleLogger;
use OSM\Core\Components\VoidLogger;
use OSM\Core\Factories\AutomapperFactory;
use OSM\Core\Factories\ConfigFactory;
use OSM\Core\Factories\DatabaseFactory;
use OSM\Core\Factories\FilesystemFactory;
use OSM\Core\Factories\OSMStateFactory;
use OSM\Core\Factories\TemplateEngineFactory;
use OSM\Core\Interfaces\ModelDataHydratorInterface;
use OSM\Core\Interfaces\SessionInterface;
use OSM\Core\Services\ModelDataHydratorService;
use OSM\Core\Structures\OSMState;
use OSM\Frontend\Services\SessionService;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use TheApp\Components\CommandRunner;
use TheApp\Factories\CommandRunnerFactory;
use TheApp\Factories\RouterFactory;
use TheApp\Interfaces\ConfigInterface;
use TheApp\Interfaces\RouterInterface;

return [
    ConfigInterface::class => fn(ConfigFactory $configFactory) => $configFactory->build(),
    LoggerInterface::class => fn(ContainerInterface $container) => $container->get(APP_TYPE === AppTypes::TYPE_CONSOLE ? ConsoleLogger::class : VoidLogger::class),
    RouterInterface::class => fn(RouterFactory $routerFactory, ConfigInterface $config) => $routerFactory->buildFromConfig($config),
    CommandRunner::class => fn(CommandRunnerFactory $commandRunnerFactory, ConfigInterface $config) => $commandRunnerFactory->fromConfig($config),
    Engine::class => fn(TemplateEngineFactory $factory, ConfigInterface $config) => $factory->fromConfig($config),
    SessionInterface::class => fn(ContainerInterface $container) => $container->get(SessionService::class),
    Database::class => fn(DatabaseFactory $factory, ConfigInterface $config) => $factory->fromConfig($config),
    AutoMapper::class => fn(ConfigInterface $config, AutoMapperFactory $autoMapperFactory) => $autoMapperFactory->fromConfig($config),
    ModelDataHydratorInterface::class => fn(ContainerInterface $container) => $container->get(ModelDataHydratorService::class),
    OSMState::class => fn(OSMStateFactory $factory) => $factory->build(),
    Filesystem::class => fn(FilesystemFactory $factory) => $factory->build(),
];
